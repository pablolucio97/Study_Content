# REACT AND NATIVE DEVELOPMENT GOOD PRACTICES CHECKLIST

## DEVELOPMENT CHECKLIST

- Use image placeholders for avatars when there's no configured avatar.

- Use the prop `ListEmptyComponent` on `FlatList` to render a secondary component when there is no data to feed the `FlatList`.

- Check if all inputs are cleared after inputting the data.

- Check for `console.log` before committing.

- Save from Figma each image you will use in your application in the 3 sizes:  
  `logo.png`, `logo@2x.png`, `logo@3x.png`, and import only `logo.png`. React Native will adjust automatically the best image size.

- Use the prop `ListEmptyComponent` on `FlatList` to render a secondary component when there is no data to feed the list.

- When styling components, use `minHeight`, `maxHeight`, `minWidth`, and `maxWidth` to avoid layout shift.

- Use `css` from styled-components (`css` helper) to avoid declaring the theme multiple times.

- Ensure `ScrollView` and `FlatList` apply `contentContainerStyle` when the list is empty.

- Ensure each input in your forms has the prop `name` and `id` to be easily tracked in a form.


## PERFORMANCE CHECKLIST AND TIPS 

- Use `FlatList` instead of `ScrollView`, because `FlatList` renders items lazily as the user scrolls, while `ScrollView` renders all items at once.

- Use a **unique item key** for each element returned by `ScrollView`, `FlatList`, or `map`. This helps React efficiently update the DOM.

- To add new elements to an array, use:  
  `setArray(prevState => [...prevState, newEl])`  
  This creates a shallow copy of the current array and respects immutability.

- To remove an item from an array, use:  
  `setArray(prevState => prevState.filter(el => !el))`

- Since `setState` is asynchronous, React might still show the previous state.  
  To access the current state immediately, use a the own callback of the setState funcion or the library `react-usestateref`.
