# Main Meta tags for SEO

Meta tags are tags that are embed inside the head tag for the HMTL docu-
ment and are useful for guide your document how to display the your 
content, idex your page and for communicate with others web services.

At working with SEO in your aplication, you are working for better results on
organic traffic.

## Basic Meta tags

```html
<meta name="description" content="Games to play for free"/>
<meta name="author" content="Pablo"/>
<meta name="keywords" content="Game, Free, Gameplay"/>
<meta name="theme-color" content="#222"/>
<meta name="rating" content="adult" />
```

## Google Robots Meta tags

Google Robots Metatag and your possible values:

```html
<meta name="robots" content="all|noindex|nofollow|none|noarchive|-
notranslate|noimageindex|nosnippet"/>
```

## Open Graph Protocol Meta tags

The Open Graph Protocol is a protocol share that enables your to share 
your page content to social media using rihc attrbutes. This protocol is
build with another many tehnologies.

### Basic Meta tags example:

```html
<meta property="og:title" content="The Rock" />
<meta property="og:type" content="video.movie" />
<meta property="og:url" content="https://www.imdb.com/title/tt0117500/" />
<meta property="og:image" content="https://ia.media-imdb.com/images/rock.jpg"/>
```


### Optional Meta tags example:

```html
<meta property="og:description" 
  content="Sean Connery found fame and fortune as the
           suave, sophisticated British agent, James Bond." />
<meta property="og:determiner" content="the" />
<meta property="og:locale" content="en_GB" />
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="es_ES" />
<meta property="og:site_name" content="IMDb" />
<meta property="og:video" content="https://example.com/bond/trailer.swf" />
```


### Image extradata Meta tags example:

```html
<meta property="og:image" content="https://example.com/ogp.jpg"/>
<meta property="og:image:secure_url" content="https://secure.example.com/ogp.jpg"/>
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="300" />
<meta property="og:image:alt" content="A shiny red apple with a bite taken out"/>
```

### Video extradata Meta tags example:

```html
<meta property="og:video" content="https://example.com/movie.swf"/>
<meta property="og:video:secure_url" content="https://one.example.com/mov.swf"/>
<meta property="og:video:type" content="application/x-shockwave-flash"/>
<meta property="og:video:width" content="400"/>
<meta property="og:video:height" content="300"/>
```


### Array of Images/Videos example (Here, the is 3 images.):

```html
<meta property="og:image" content="https://example.com/rock.jpg" />
<meta property="og:image:width" content="300" />
<meta property="og:image:height" content="300" />
<meta property="og:image" content="https://example.com/rock2.jpg" />
<meta property="og:image" content="https://example.com/rock3.jpg" />
<meta property="og:image:height" content="1000" />
```
## General Tips

- **Use Friendly URLs**: Implement user-friendly URLs. For example, `https://myapp/electronics/apple/ipad2`. Prefer dashes over underscores in URLs.

- **Effective Meta Description**: Craft a compelling description in your meta tag, as it appears in Google search rankings. Aim for a length between 50 and 160 characters.

- **Diverse Page Titles**: Ensure each page has a unique title, especially if you're not using a framework like React.

- **Organize Content with Headings**: Structure your content using headings effectively. The `h1` tag should highlight the most important content, while `h6` should represent the least important.

- **Use Alt and Title Tags for Images**: Incorporate `alt` and `title` attributes for every image to enhance accessibility and SEO.

- **Consistent File Naming**: Name your site or application's files consistently, aligning with your application's name. This aids Google's robots in displaying your content effectively.

- **Combine Texts with Images**: Integrate images alongside text. Avoid using images as the sole medium for representing text content.






