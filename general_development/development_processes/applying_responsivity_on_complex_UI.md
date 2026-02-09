
# Applying reposivity on complex UI

## Deinifing the breakpoints
To define your application breakpoints you must scroll the brwoser horizontally and mark the pixel where the layout breaks, define it as your main breakpoint, and so consider generic breakpoints (1536, 1366, 1280, 1024, and 768) as reference.

### Breakpoints references
- 1536+ large desktops
- 1280–1536 laptops
- 1024–1280 small laptops
- 768–1024 tablets
- <768 mobile

## Aplying reposivity techiniques according to the element:
- **Cards** => Fluid-witdh/flex-direction/grid-cols/paddings/gappins/font-size.
- **Text** => Max-width/font-size/line-clamp/replace for icon.
- **Sidebars** => Paddings/gappins/font-size/Line-clamp/transform to drawer element.
- **Tables and not resizable elements** => Paddings/font-size/gappins/Line-clamp/horizontal-scroll.
- **Headers** =>  Paddings/font-size/replace for icon/hide some elements/gappins/transform to drawer element.
- **Footers** => Flex direction/grid-cols/paddings/font-size/paddings/gappins.

## General tips
- Use generic breakpoints just as reference, your main breakpoint must be where your applications breaks horizontally.
- Avoid fixed widths and heighs as possible.
- Consider transforming components instead of just resizing it.
- Use REM unitity value for fonts, spacings and withs to the layout be able to scale according to resizing, zoom, or accessibility settings.
- Understand overflow behaviors.
- Know when to use `flex`, `flex-wrap`, `grid-cols (minmax, auto-fit, auto-fill, fr, col-span)`, and  `grid-template`.
- Know when to use `clamp for font-size`
- Know when to hide some element.
- Know wich techiniques to apply for cards, tables, side panels and so on.
- When a table is too complex, you can transform it on several cards where each card represents a row.
- Sometimes an element's width is being controlled by its parent instead by itself, specially when ruled grid-cols or grid-template.