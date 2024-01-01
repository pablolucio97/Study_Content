# MAIN WEB BROWSERS OBJECTS

## WINDOW OBJECT

Represents a browser window or frame and provides methods and properties for controlling the window. It serves as the global object for all code running in the browser window and contains functions related to the window itself, such as methods to control the browser window and variables that provide information about the window's environment.

### Main Window Object Properties

- **closed**: Returns a Boolean value indicating whether a window has been closed or not.
- **screenLeft**: Returns the horizontal coordinate of the window relative to the screen.
- **screenTop**: Returns the vertical coordinate of the window relative to the screen.
- **screenX**: Returns the horizontal coordinate of the window relative to the screen.
- **screenY**: Returns the vertical coordinate of the window relative to the screen.
- **sessionStorage**: Allows to save key/value pairs in a web browser for one session.
- **self**: Returns the current window.
- **status**: Sets or returns the text in the status bar of a window.

### Main Window Object Methods

- **alert()**: Displays an alert box with a message and an OK button.
- **blur()**: Removes focus from the current window.
- **clearInterval()**: Clears a timer set with setInterval().
- **clearTimeout()**: Clears a timer set with setTimeout().
- **close()**: Closes the current window.
- **confirm()**: Displays a dialog box with a message and an OK and a Cancel button.
- **focus()**: Sets focus to the current window.
- **moveTo()**: Moves a window to the specified position.
- **open()**: Opens a new browser window.
- **print()**: Prints the content of the current window.
- **prompt()**: Displays a dialog box that prompts the visitor for input.
- **resizeTo()**: Resizes the window to the specified width and height.
- **scrollTo()**: Scrolls the document to the specified coordinates.
- **setInterval()**: Calls a function or evaluates an expression at specified intervals (in milliseconds).
- **setTimeout()**: Calls a function or evaluates an expression after a specified number of milliseconds.
- **stop()**: Stops the window from loading.

### CONSOLE OBJECT

Provides access to the browser's debugging console. It offers a variety of methods to output and manipulate the console output, such as logging information, warnings, errors, and more. The console object is useful for debugging purposes.

### METHODS

- **assert()**: Writes an error message to the console if the assertion is false.
- **clear()**: Clears the console.
- **count()**: Logs the number of times this particular call to count() has been called.
- **error()**: Outputs an error message to the console.
- **group()**: Creates a new inline group in the console.
- **groupCollapsed()**: Creates a new inline group in the console, collapsed.
- **info()**: Outputs an informational message to the console.
- **log()**: Outputs a message to the console.
- **table()**: Displays tabular data as a table.
- **time()**: Starts a timer.
- **timeEnd()**: Stops a timer previously started by console.time().
- **trace()**: Outputs a stack trace to the console.
- **warn()**: Outputs a warning message to the console.

## History Object

Provides access to the browser's session history. This object allows manipulation of the browser's session history, enabling web applications to navigate the user back and forth through that history, as well as load specific pages from the history stack.

### Properties

- **Length**: Returns the number of URLs in the history list.

### Methods

- **back()**: Loads the previous URL in the history list.
- **forward()**: Loads the next URL in the history list.
- **go()**: Loads a specific URL from the history.

## LOCATION OBJECT

Represents the location (URL) of the object it is linked to. This object contains properties for reading and altering the current URL and can be used for redirecting the browser to another URL.

### Properties

- **hash**: Sets or returns the anchor part of the URL.
- **host**: Sets or returns the hostname and port number of the URL.
- **hostname**: Sets or returns the hostname of the URL.
- **href**: Sets or returns the entire URL.
- **origin**: Returns the protocol, hostname, and port number of a URL.
- **pathname**: Sets or returns the pathname of a URL.
- **port**: Sets or returns the port number of a URL.
- **search**: Sets or returns the query string part of the URL.

### Methods

- **assign()**: Loads a new document.
- **reload()**: Reloads the current document.
- **replace()**: Replaces the current document with a new one.

## Navigator Object

Represents the state and the identity of the user's browser. It includes properties and methods that give information about the browser version, the operating system, and other details regarding the user's environment.

### Properties

- **appCodeName**: Returns the code name of the browser.
- **appName**: Returns the name of the browser.
- **appVersion**: Returns the version of the browser.
- **cookieEnabled**: Determines whether cookies are enabled in the browser.
- **geolocation**: Returns a Geolocation object.
- **language**: Returns the language of the browser.
- **online**: Determines whether the browser is online.
- **platform**: Returns for which platform the browser is compiled.
- **product**: Returns the engine name of the browser.
- **userAgent**: Returns the user-agent header sent by the browser to the server.

### Methods

- **javaEnabled()**: Specifies whether or not the browser has Java enabled.

## Screen Object

Provides information about the user's screen, such as its resolution, color depth, and dimensions. It’s useful for understanding how much screen real estate is available for your web application.

### Properties

- **availHeight**: Returns the height of the screen, excluding the Windows Taskbar.
- **availWidth**: Returns the width of the screen, excluding the Windows Taskbar.
- **colorDepth**: Returns the bit depth of the color palette for displaying images.
- **height**: Returns the total height of the screen.
- **pixelDepth**: Returns the color resolution in pixels of the screen.
- **width**: Returns the total width of the screen.

## SessionStorage Object

Similar to LocalStorage, but it stores data only for the duration of the page session. Data stored in SessionStorage is cleared when the page session ends (e.g., when the browser tab is closed). It’s useful for storing temporary information that should not persist between sessions.

### Properties

- **length**: Returns the number of data items stored in the sessionStorage.

### Methods

- **clear()**: Clears all key/value pairs in the sessionStorage for the current domain.
- **getItem(key)**: Returns the value associated with a given key in the sessionStorage, or `null` if the key does not exist.
- **key(n)**: Returns the name of the nth key in the sessionStorage, or `null` if n is greater than or equal to the number of key/value pairs.
- **removeItem(key)**: Removes the key/value pair with the given key from the sessionStorage, if it exists.
- **setItem(key, value)**: Adds a key/value pair to the sessionStorage, or updates the value if the key already exists.
