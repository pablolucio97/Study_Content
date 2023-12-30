# IMPROVING SEO ON NEXTJS PROJECTS

To enhance SEO in your NextJS projects, focus on Meta Tags, Performance, Accessibility, and Progressive Web Apps (PWAs).

## Meta Tags

Meta tags provide information about a web page's content to search engines. They are crucial for SEO as they influence how search engines interpret and display your pages.

### Important Meta Tags

1. **Use `next/head` for Meta Tags**:
   - Include meta tags in each page of your application with a unique key.
   - Example:
     ```html
     <meta charset="UTF-8">
     <meta name="viewport" content="initial-scale=1.0, width=device-width" />
     <meta name="description" content="pablosilvadev" key="description" />
     <meta name="author" content="Pablo Silva" key="author" />
     <meta name="theme-color" content="#000000" key="theme-color" />
     ```

    - **Title**: The page title displayed in Google search. Essential for giving users insight into the content.
    - **Description**: Summarizes page content. Search engines often use this for the snippet in search results.
    - **Robots**: Directs how search engines should crawl your web pages.
    - **Viewport**: Indicates mobile-friendliness, impacting search rankings.
    - **Charset**: Specifies text encoding, ensuring correct text display.

## Performance

Performance is gauged by metrics like First Contentful Paint (FCP) and Largest Contentful Paint (LCP). Use Next.js to track these metrics with a custom `reportWebVitals` function in `app.tsx`.

- Example:
  ```js
  export function reportWebVitals(metric) {
    console.log(metric)
  }
