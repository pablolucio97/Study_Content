# HTML ELEMENTS AND ATTRIBUTES=

## GLOBAL ATTRIBUTES

- **accesskey**: Get a tip to generate a key shortcut for the current element.

- **autocapitalize**: Define if an element should be displayed in capital letters. Enum: off, none, sentences, words, characters.

- **class**: Apply a created class to the element.

- **contenteditable**: Defines if content is editable or not. Boolean.

- **dir**: Appoint the text direction. Enum: ltr, rtl, auto.

- **draggable**: Defines if an element is draggable or not.

- **id**: A string used to locate a unique element.

- **itemid**: A string used to locate a unique item.

- **lang**: Used to define the language.

- **spellcheck**: Defines if the element can be subject to spell correction. Boolean.

- **style**: Show CSS declarations used to style the element.

- **tabindex**: A number passed to represent the usage index of the Tab key and focus this element. Negative, 0, and positive values.

## ELEMENTS

- **<a>**: Creates a hyperlink to pages, files, locations in the current document, email addresses, and more.
    - **href**: URL to access link.
    - **rel**: Defines the relationship type of the URL. Enum: author, external, icon, stylesheet, tag.
    - **target**: Defines where to open the new link. Enum: _self, _blank, _top.

- **<area>**: Used with <map> element inside images to define clickable areas to link a URL.
    - **alt**: A string text used to display in browsers that do not display images.
    - **coords/shape**: Specify the coordinates of the clickable region. Enum: rect, circle.
    - **href**: URL to access link.
    - **rel**: Defines the relationship type of the URL. Enum: author, external, icon, stylesheet, tag.
    - **target**: Defines where to open the new link. Enum: _self, _blank, _top.

- **<article>**: Displays text and typography elements in a self-contained container.

- **<aside>**: Represents a portion of the document showing texts as sidebars.

- **<audio>**: Creates an audible element.
    - **controls** (read-only): Defines if the controls should be displayed.
    - **autoplay**: Defines if audio should play on page load. Boolean.
    - **currentTime**: Returns the current time position of the execution of the audio.
    - **duration** (read-only): Returns the audio duration.
    - **loop**: Defines if the audio should loop. Boolean.
    - **muted**: Defines if the audio should be muted.
    - **preload**: Defines the preload behavior. Enum: none, metadata, auto.
    - **src**: Defines the source of the audio file.

- **<b>**: Turns a text bold.

- **<blockquote>**: Used for citations.
    - **cite**: The URL of the citation.

- **<body>**: Represents all HTML document content.
    - Event attributes like **onafterprint**, **onbeforeprint**, **onbeforeunload**, etc.

- **<br>**: Creates a line break.

- **<button>**: Creates a button used to submit forms or call functions.
    - **autofocus**: Defines whether the button should receive focus on page load. Boolean.
    - **disabled**: Disables the button. Boolean.
    - **name**: The button name submitted as part of the form data.
    - **type**: Defines the button behavior. Enum: submit, reset, button.
    - **value**: Defines the values associated with the button's name when submitting the form data.

- **<canvas>**: Creates a graphical container for animations.
    - **height**: The height of the canvas container.
    - **width**: The width of the canvas container.

- **<caption>**: Defines a title for tables.

- **<code>**: Refers to a code snippet, giving style emphasis.

- **<col>**: Defines a column within a table.

- **<colgroup>**: Defines a group of columns within a table.

- **<data-list>**: Provides a list of available items in a search. Should be used with an input and <datalist> element with options.

- **<details>**: Creates a disclosure widget that shows information only when toggled open.

- **<dialog>**: Represents a dialog box or other interactive component.

- **<div>**: A generic container for flow content.

- **<em>**: Gives text an italic format.

- **<embed>**: Embeds external content.
    - **height**: The height of the content.
    - **width**: The width of the content.
    - **src**: The local path or link to the file.
    - **type**: The type of file to embed.

- **<fieldset>**: Groups several controls and labels within a form.
    - **disabled**: Disables all child controls.
    - **form**: Associates with a form element.

- **<figcaption>**: Provides a title for an image.

- **<figure>**: A specific container for images.

- **<footer>**: Represents the final section of the document body.

- **<form>**: Groups input controls to submit data.
    - Attributes like **action**, **autocomplete**, **enctype**, **method**, **name**, etc.

- **<i>**: Applies italic format to text.

- **<iframe>**: Represents a nested browsing context.
    - Attributes like **allowfullscreen**, **allowpaymentrequest**, **height**, **width**, etc.

- **<img>**: Embeds an image.
    - **src**: The URL of the image.
    - **alt**: A brief description of the image.

- **<input>**: Creates data input fields.
    - Various types and attributes like **accept**, **alt**, **autocomplete**, **autofocus**, etc.

- **<h1>–<h6>**: Represent six levels of section headings.

- **<head>**: Contains metadata about the document.

- **<header>**: Introductory content or navigational aids.

- **<hr>**: Represents a thematic break or divider.

- **<html>**: The root element of an HTML document.
    - **xmlns**: Required in XML-parsed documents.

- **<kbd>**: Indicates user input.

- **<label>**: Caption for an item in a user interface.
    - **for**: Associates with a form control.
    - **form**: Associates with a form element.

- **<legend>**: Caption for the content of a <fieldset>.

- **<li>**: Represents an item in a list.
    - **value**: Indicates the current ordinal value of the list item.

- **<link>**: Represents relationships between the document and external resources.
    - Attributes like **as**, **href**, **rel**, **sizes**, etc.

## =TIPS==

- Only one element should have the `autofocus` property in an entire HTML document.
- The `<caption>` element should be the first child of its parent `<table>` element.
- The `tabindex` attribute must not be used on the `<dialog>` element.
- `<link>` elements should be placed in the head.
- Use HTML native tags rather than `<div>` elements to represent forms.
