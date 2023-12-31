# CSS3 Course Overview

## General Considerations

- **Priority:** Browsers prioritize inline and internal styles over external files.
- **Box Model:** Element size is calculated as width/height + padding + border. Elements are treated as boxes with content, padding, border, and margin.
- **Display Property:** Default values vary based on the element (e.g., `span`: inline, `div`: block).
- **Box Sizing:** With `box-sizing`, define maximum limits for the border-box, considering content and padding. `overflow` sets box limits and behavior.
- **Margins:** CSS doesn't sum margins between elements and doesn't apply margin-auto vertically.

## Units

### Fixed Values

- `cm`: centimeters
- `mm`: millimeters
- `in`: inches (1in = 96px = 2.54cm)
- `px`: pixels (1px = 1/96th of 1in)
- `pt`: points (1pt = 1/72 of 1in)
- `pc`: picas (1pc = 12 pt)

### Relative Values

- `em`: relative to the font-size of the element
- `rem`: relative to font-size of the root element
- `vw`: 1% of the width of the viewport
- `vh`: 1% of the height of the viewport
- `vmin`: 1% of viewport's smaller dimension
- `vmax`: 1% of viewport's larger dimension
- `%`: relative to the parent element

## CSS Selectors

- `div p`: selects all `<p>` elements inside `<div>` elements
- `div > p`: selects all `<p>` elements where the parent is a `<div>` element
- `div + p`: selects all `<p>` elements next to `<div>` elements
- `p ~ u`: selects every `<ul>` element preceded by a `<p>` element

## Main Properties

### Display

- `inline`, `block`, `flex`, `grid`, `none`, `contents`
- Flex and Grid properties: `flex-direction`, `flex-wrap`, `flex-flow`, `justify-content`, `align-items`, `grid-template-columns`, `grid-template-rows`, `grid-gap`, `grid-column`, `grid-row`

### Visibility

- `hidden`, `inherit`, `visible`

### Position

- `static`, `absolute`, `fixed`, `relative`

### Box-Sizing

- `border-box`, `content-box`

### Overflow

- `hidden`, `visible`, `scroll`, `auto`, `overflow-x`, `overflow-y`

### Z-index

- Specifies the stack order of elements

### Float

- `left`, `right`, `none`, `inherit`

### Spaces

- `margin`, `padding`

### Background

- `background`, `background-color`, `background-img`, `background-repeat`, `background-position`, `background-attachment`

### Border

- `border`, `border-width`, `border-color`, `border-radius`, `border-style`

### Outline

- `outline`, `outline-style`, `outline-color`, `outline-width`, `outline-offset`

### Text

- `text-align`, `text-decoration`, `text-transform`, `text-indent`, `text-direction`, `text-shadow`, `word-spacing`, `letter-spacing`

### Font

- `font-family`, `font-weight`, `font-style`, `font-size`

### Line

- `line-height`

### List

- `list-style`

## Transitions and Animations

- `transition`, `transition-delay`
- 2D/3D Transforms: `translate`, `rotate`, `skew`, `scale`, `matrix`, `rotateX`, `rotateY`, `rotateZ`, `translateX`, `translateY`, `translateZ`, `scaleX`, `scaleY`, `scaleZ`
- Animation properties: `animation-name`, `animation-duration`, `animation-iteration-count`, `animation-delay`

## Pseudo-Classes and Elements

- Pseudo-classes: `:a`, `:visited`, `:hover`, `:active`, `:checked`, `:focus`, `:target`
- Pseudo-elements: `::before`, `::after`, `::first-letter`, `::first-line`, `::selection`

## CSS Reset

```css
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

:root {
  --white: #fff;
  --background: #f2f3f5;
  --gray-line: #dcdde0;
  --text: #666666;
  --text-highlight: #b3b9ff;
  --title: #2e384d;
  --red: #e83f5b;
  --green: #4cd62b;
  --blue: #5965e0;
  --blue-dark: #4953b8;
  --blue-twitter: #2aa9e0;
}

@media(max-width: 1080px) {
  html {
    font-size: 93.75%;
  }
}

@media(max-width: 720px) {
  html {
    font-size: 87.5%;
  }
}
``````

## General Tips for CSS Styling

- **Base Configuration:** Start with a `globals.css` file for base configurations and adjust other files as needed.

- **Font and Space Measurements:** Use the `rem` unit for font sizes and `em` for spaces (padding or margin) to enhance responsiveness.

- **Color Usage:** Employ hexadecimal values for color specifications.

- **CSS Grid Layout:** Opt for CSS grid layout for page structures with more than 10 columns.

- **Text Alignment:** Prefer using flexbox over the `text-align` property for aligning text.

- **Outline Handling:** If you remove an outline from an element, apply an alternative style when the element is active. This improves user experience by indicating focus.

- **Root Variables:** Set the `:root` of the document with color variables and font sizes for easy layout adjustments.

- **Height and Font Properties:** Always set the height for `html` and `body` elements and define font properties for `body`, `input`, and `form` elements.

- **CSS Selectors for Animation:** Use CSS selectors to trigger animations or transitions in other elements through interaction with a specific element.

- **Animation Performance:** Ensure animations are optimized for low-end devices. It's better to have no animations than to have poorly performing ones.

- **Default Font Size:** The default font size in most browsers is 16px, equivalent to 1rem.

