# DOM OBJECT

## Props

**activeElement**:
- Returns the currently focused element in the document.

**anchors**:
- Returns a collection of all `<a>` elements in the document that have a name attribute.

**body**:
- Returns the `<body>` element.

**cookie**:
- Returns all name/value pairs of cookies in the document.

**characterSet**:
- Returns the character encoding for the document.

**defaultView**:
- Returns the window object associated with a document, or null if none is available.

**designMode**:
- Controls whether the entire document should be editable.

**documentURI**:
- Sets or returns the location of the document.

**domain**:
- Returns the domain name of the server that loaded the document.

**embeds**:
- Returns a collection of all `<embed>` elements in the document.

**forms**:
- Returns a collection of all `<form>` elements in the document.

**fullscreenElement**:
- Returns the current element that is displayed in fullscreen mode.

**head**:
- Returns the `<head>` element of the document.

**images**:
- Returns the collection of all `<img>` elements in the document.

**lastModified**:
- Returns the date and time the document was last modified.

**links**:
- Returns a collection of all `<a>` and `<area>` elements in the document that have a href attribute.

**readyState**:
- Returns the loading status of the document.

**referrer**:
- Returns the URL of the document that loaded the current document.

**scripts**:
- Returns a collection of `<script>` elements in the document.

**title**:
- Sets or returns the title of the document.

**URL**:
- Returns the entire URL of the HTML document.

## METHODS

**addEventListener()**:
- Attaches an event handler to the document.

**adoptNode()**:
- Adopts a node from another document.

**close()**:
- Closes the output stream previously opened with document.open().

**createAttribute()**:
- Creates an attribute node.

**createComment()**:
- Creates a comment node with specified text.

**createDocumentFragment()**:
- Creates an empty DocumentFragment node.

**createElement()**:
- Creates an Element node.

**createEvent()**:
- Creates a new event.

**createTextNode()**:
- Creates a Text node.

**fullscreenEnabled()**:
- Returns a boolean value indicating whether the document can be viewed in fullscreen mode.

**getElementById()**:
- Returns the element that has the ID attribute with the specified name.

**getElementsByClassName()**:
- Returns a HTML collection containing all elements with the specified value.

**getElementsByTagName()**:
- Returns a HTML collection containing all elements with the specified tag name.

**hasFocus()**:
- Returns a boolean value indicating whether the document has focus.

**importNode()**:
- Imports a node from another document.

**normalize()**:
- Removes empty Text nodes, and joins adjacent nodes.

**open()**:
- Opens an HTML output stream to collect output from document.write().

**querySelector()**:
- Searches for an element in a specific position in the document, e.g., `querySelector('div#container input')` gets the input inside the div with id container, or `querySelector('button[name=calc]')`.

**querySelectorAll()**:
- Returns a static NodeList containing all elements that match a specified CSS selector(s) in the document.

**removeEventListener()**:
- Removes an event handler added by the addEventListener() method from the document.

**renameNode()**:
- Renames the specified node.

**write()**:
- Writes HTML expressions or JavaScript code to the document.

**writeln()**:
- Writes HTML expressions or JavaScript code to the document, adding a newline character after each statement.
