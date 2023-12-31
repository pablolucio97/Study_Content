## CSS Utils

### Image Reflection Effect

Mirror  reflection effect for an image:

```css
-webkit-box-reflect: below 4px linear-gradient(to bottom, rgba(0,0,0,0), rgba(0, 0, 0, 0.3));
```

### Tap Highlight Color

Changes the color of the tap highlight on touch devices:

```css
-webkit-box-reflect: below 4px linear-gradient(to bottom, rgba(0,0,0,0), rgba(0, 0, 0, 0.3));
```

### Overflow Scrolling

Provides a smoother scrolling experience on touch devices.

```css
-webkit-overflow-scrolling: touch;
```

### User Select

Controls the ability of the user to select text.

```css
-webkit-user-select: none;
```

### Line Clamping

Limits the number of lines in a text block and provides an ellipsis for overflow.

```css
display: -webkit-box;
-webkit-line-clamp: 3;
-webkit-box-orient: vertical;
overflow: hidden;
```

### Scrollbar styling

Styles web browser's scrollbar.

```css
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #888;
}
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
```
