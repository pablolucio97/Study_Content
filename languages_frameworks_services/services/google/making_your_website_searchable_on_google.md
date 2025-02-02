# Making Your Website Searchable on Google

Making your website searchable on Google is a process that involves multiple steps to optimize visibility and ensure proper indexing.

## Key Steps for Google Searchability

- **Implement Good SEO Practices**: 
  - Add meta tags such as `title`, `author`, `description`, and Open Graph (OG) tags for all pages of your application.
  - Ensure your meta tags contain relevant keywords to improve discoverability.

- **Ensure Sitemap and Robots Files**:
  - Create a `sitemap.xml` file and make it accessible at `https://www.your-website.your-domain/sitemap.xml`.
  - Create a `robots.txt` file to allow crawlers to index your site. It should be accessible at `https://www.your-website.your-domain/robots.txt`.

- **Provide an OG Image**:
  - Place an image named `og-image.png` at the root of your website. This image is used when sharing your site on social media.
  - Test the image's availability at `https://www.your-website.your-domain/og-image.png`.

---

## Adding Your Site to Google Search Console

1. **Submit Your Website**:
   - Visit [Google Search Console](https://search.google.com/search-console).
   - Add your website's URL and click **Continue**.

2. **Verify Ownership**:
   - Copy the TXT verification code provided by Google.
   - Add the TXT record to your domain manager (e.g., Registro BR, GoDaddy).

3. **Submit Your Sitemap**:
   - Go to the **Sitemaps** section of Google Search Console.
   - Submit the full URL of your sitemap (e.g., `https://www.your-website.your-domain/sitemap.xml`).

---

Test searching your website at Google, if your website does not appears, try search it as `site:your-wesite.domain`, ex: `site:treinahub.com.br`.

Observation: Google can takes until 48h to index your site. You can follow the process at Google Search Console.
  