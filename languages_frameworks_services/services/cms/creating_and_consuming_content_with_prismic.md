# CREATING AND CONSUMING CONTENT WITH PRISMIC

Prismic is a CMS that allows you to create content to consume in your apps. Basically, you can create documents, types, images, and establish relationships between them.

1. **Log in to Prismic**, go to the dashboard and click on 'Create Repository'. Click on your new content and select the language to write the content.

---

2. Click on 'Custom Type' and create a new type that can be "Repeatable type" or "Single type". In this case, we'll be using "Repeatable type". Give a name for your type and click on 'Create new custom type'.

---

3. Inside your type, drag each "Build mode" according to your desired data to create your type structure. You can drag "UID", "Title", "Rich Text", and other builds. Provide a name for each build that will be how the data will be consumed in your application.

---

4. If you want, create the content of your types by clicking on 'Document' at the dashboard, edit and publish it.

---

5. Go to 'Settings', 'API and Security'. In the 'Repository security', define if your content will be private or public and click on 'Change API Visibility'. Copy the endpoint URL and save it as a .env variable to access Prismic. In the 'Generate an Access Token' field, provide a name for your application and click on 'Add this application'. A token will be generated; copy it at 'Permanent access tokens' label and use it as an env variable.

---

6. Run `yarn add @prismicio/client yarn add prismic-dom` and `yarn add @types/prismic-dom` to install Prismic in your project.

---

7. Create a new file named `prismic.ts` inside your services folder, instancing a new `Prismic.client` passing your .env variable as config. Example:

   ```javascript
   import Prismic from "@prismicio/client";

   export function getPrismicClient(req?: unknown) {
     const prismic = Prismic.client(process.env.PRISMIC_URL, {
       req,
       accessToken: process.env.PRISMIC_ACCESS_TOKEN,
     });
     return prismic;
   }
   ```

---
8. Import the getPrismicClient function and the Prismic and consume the Prismic content in your application. You should pass a query to get your content where document.type is the type of document created on Prismic. Example:

```typescript
import { GetStaticProps } from 'next';
import { getPrismicClient } from '../../services/prismic';
import Prismic from '@prismicio/client';
import { RichText } from 'prismic-dom';

type Post = {
    slug: string;
    title: string;
    excerpt: string;
    updatedAt: string;
};

type Posts = {
    posts: Post[];
};

export default function Posts({ posts }: Posts) {
    return (
        <>
            <main className={styles.container}>
                <div className={styles.posts}>
                {posts.map(post => (
                    <a href="#" key={post.slug}>
                         <time>{post.updatedAt}</time>
                         <strong>{post.title}</strong>
                         <p>{post.excerpt}</p>
                     </a>
                ))}
                </div>
            </main>
        </>
    );
}

export const getStaticProps: GetStaticProps = async () => {
    const prismic = getPrismicClient();

    const response = await prismic.query([
        Prismic.predicates.at('document.type', 'post')
    ], {
        fetch: ['post.title', 'post.content'],
        pageSize: 100
    });

    const posts = response.results.map(post => {
        return {
            slug: post.uid,
            title: RichText.asText(post.data.title),
            excerpt: post.data.content.find(content => content.type === 'paragraph')?.text ?? '',
            updatedAt: new Date(post.last_publication_date).toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            })
        };
    });

    return {
        props: {
            posts
        }
    };
}
```