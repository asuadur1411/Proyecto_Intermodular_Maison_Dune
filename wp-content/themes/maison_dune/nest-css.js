/**
 * CSS Flat-to-Nested Converter
 * Converts ".parent .child { ... }" to ".parent { .child { ... } }" syntax.
 * Only processes lines after the ROOMS DARK INTRO section comment.
 */
const fs = require('fs');

const FILE = 'c:\\laragon\\www\\maison\\wp-content\\themes\\maison_dune\\style.css';
const css = fs.readFileSync(FILE, 'utf-8');
const lines = css.split('\n');

// Find where the already-converted sections end and flat sections begin
const darkIntroIdx = lines.findIndex(l => l.includes('ROOMS DARK INTRO'));
if (darkIntroIdx === -1) { console.log('Marker not found'); process.exit(1); }

// Keep everything before ROOMS DARK INTRO as-is
const before = lines.slice(0, darkIntroIdx).join('\n');
const after = lines.slice(darkIntroIdx).join('\n');

// Parse CSS blocks from the flat portion
function parseTopLevel(text) {
  const result = [];
  let i = 0;
  while (i < text.length) {
    // Skip whitespace
    while (i < text.length && /[\s\n\r]/.test(text[i])) i++;
    if (i >= text.length) break;

    // Comment
    if (text[i] === '/' && text[i+1] === '*') {
      const end = text.indexOf('*/', i) + 2;
      result.push({ type: 'comment', text: text.substring(i, end) });
      i = end;
      continue;
    }

    // @media or @keyframes
    if (text[i] === '@') {
      const braceIdx = text.indexOf('{', i);
      const selector = text.substring(i, braceIdx).trim();
      i = braceIdx + 1;
      let depth = 1;
      const bodyStart = i;
      while (i < text.length && depth > 0) {
        if (text[i] === '{') depth++;
        else if (text[i] === '}') depth--;
        i++;
      }
      result.push({ type: 'at-rule', selector, body: text.substring(bodyStart, i-1).trim() });
      continue;
    }

    // Regular rule
    const braceIdx = text.indexOf('{', i);
    if (braceIdx === -1) break;
    const selector = text.substring(i, braceIdx).trim();
    i = braceIdx + 1;
    let depth = 1;
    const bodyStart = i;
    while (i < text.length && depth > 0) {
      if (text[i] === '{') depth++;
      else if (text[i] === '}') depth--;
      i++;
    }
    result.push({ type: 'rule', selector, body: text.substring(bodyStart, i-1).trim() });
  }
  return result;
}

// Groups of selectors to nest under their root
const blocks = parseTopLevel(after);
const output = [];
let currentRoot = null;
let currentChildren = [];
let currentBase = null;

function flushRoot() {
  if (!currentRoot) return;
  let out = `${currentRoot} {\n`;
  if (currentBase) {
    currentBase.split('\n').forEach(l => {
      const t = l.trim();
      if (t) out += `  ${t}\n`;
    });
  }
  for (const child of currentChildren) {
    out += '\n';
    if (child.isAtRule) {
      out += `  ${child.selector} {\n`;
      // Re-parse inner rules and strip root prefix
      const innerBlocks = parseTopLevel(child.body);
      for (const ib of innerBlocks) {
        if (ib.type === 'rule') {
          const stripped = stripRoot(ib.selector, currentRoot);
          const sel = stripped || '&';
          out += `    ${sel} {\n`;
          ib.body.split('\n').forEach(l => {
            const t = l.trim();
            if (t) out += `      ${t}\n`;
          });
          out += `    }\n`;
        }
      }
      out += `  }\n`;
    } else {
      out += `  ${child.selector} {\n`;
      child.body.split('\n').forEach(l => {
        const t = l.trim();
        if (t) out += `    ${t}\n`;
      });
      out += `  }\n`;
    }
  }
  out += `}\n`;
  output.push(out);
  currentRoot = null;
  currentChildren = [];
  currentBase = null;
}

function getRoot(selector) {
  // Match .class-name or .class-name.modifier
  const m = selector.match(/^(\.[a-zA-Z][a-zA-Z0-9_-]*(?:\.[a-zA-Z][a-zA-Z0-9_-]*)?)/);
  if (!m) return null;
  const root = m[1];
  const rest = selector.substring(root.length).trim();
  return { root, rest };
}

function stripRoot(selector, root) {
  if (selector.startsWith(root + ' ')) {
    return selector.substring(root.length + 1);
  }
  if (selector.startsWith(root + ':')) {
    return '&' + selector.substring(root.length);
  }
  if (selector === root) {
    return null;
  }
  return selector;
}

for (const block of blocks) {
  if (block.type === 'comment') {
    flushRoot();
    output.push(block.text);
    continue;
  }

  if (block.type === 'rule') {
    const info = getRoot(block.selector);
    if (info) {
      if (currentRoot && currentRoot !== info.root) {
        flushRoot();
      }
      currentRoot = info.root;
      if (!info.rest) {
        // This is the root itself
        currentBase = (currentBase || '') + (currentBase ? '\n' : '') + block.body;
      } else {
        // Descendant or pseudo
        const nested = stripRoot(block.selector, currentRoot);
        currentChildren.push({ selector: nested, body: block.body });
      }
      continue;
    }
    // Standalone rule, not nestable
    flushRoot();
    let out = `${block.selector} {\n`;
    block.body.split('\n').forEach(l => {
      const t = l.trim();
      if (t) out += `  ${t}\n`;
    });
    out += `}\n`;
    output.push(out);
    continue;
  }

  if (block.type === 'at-rule') {
    // Check if all inner rules belong to currentRoot
    if (currentRoot) {
      const innerBlocks = parseTopLevel(block.body);
      const allBelong = innerBlocks.every(ib => {
        if (ib.type !== 'rule') return true;
        return ib.selector.startsWith(currentRoot + ' ') || ib.selector.startsWith(currentRoot + ':') || ib.selector === currentRoot;
      });
      if (allBelong) {
        currentChildren.push({ selector: block.selector, body: block.body, isAtRule: true });
        continue;
      }
    }
    flushRoot();
    let out = `${block.selector} {\n`;
    block.body.split('\n').forEach(l => {
      const t = l.trim();
      if (t) out += `  ${t}\n`;
    });
    out += `}\n`;
    output.push(out);
    continue;
  }
}

flushRoot();

const finalCss = before + '\n' + output.join('\n');
fs.writeFileSync(FILE, finalCss, 'utf-8');
console.log('Done - CSS sections converted to nested syntax');
