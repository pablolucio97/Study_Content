
# Robots and Sitemap

## robots.txt

A plain text file placed at the root of your site (`https://your-site.com/robots.txt`). It instructs search engine crawlers which pages or sections they are **allowed or forbidden to crawl**. It does not prevent pages from being indexed if other sites link to them — it only controls crawler access.

Common use cases:
- Block crawlers from admin panels, staging areas, or duplicate content pages
- Allow all crawlers to access the full site (default for most public sites)

```
# Allow all crawlers everywhere
User-agent: *
Disallow:

# Block all crawlers from the admin area
User-agent: *
Disallow: /admin/
```

## sitemap.xml

An XML file placed at the root of your site (`https://your-site.com/sitemap.xml`). It **lists all the pages you want Google to know about and index**. It helps crawlers discover pages that might not be easily reachable through internal links, and can include metadata like last modification date and priority.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://your-site.com/</loc>
    <lastmod>2025-01-01</lastmod>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://your-site.com/services/</loc>
    <lastmod>2025-01-01</lastmod>
    <priority>0.8</priority>
  </url>
</urlset>
```

Submit the sitemap URL in Google Search Console so Google can find and process it faster.

## Key difference

| | robots.txt | sitemap.xml |
|---|---|---|
| **Purpose** | Controls what crawlers can access | Tells crawlers what pages exist |
| **Action** | Blocks or allows crawling | Guides discovery and indexing |
| **Format** | Plain text | XML |
| **Analogy** | A "do not enter" sign | A map of all rooms in the building |

Both files complement each other: `robots.txt` controls access, `sitemap.xml` guides discovery. A page blocked in `robots.txt` should not appear in `sitemap.xml`.