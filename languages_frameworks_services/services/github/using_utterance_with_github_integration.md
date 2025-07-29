# USING UTTERANCES WITH GITHUB INTEGRATION IN YOUR APPLICATION

**Utterances** is a lightweight comments widget built on GitHub Issues. It enables users to comment on your application pages using their GitHub account.

---

## Step-by-step Setup

### 1. Prepare Your Repository

- Make sure your GitHub repository is **public**.
- If it's a fork, enable the **Issues** feature under repository **Settings > Features > Issues**.
- Install Utterances from the GitHub Marketplace:  
  `https://github.com/marketplace/utterances`

---

### 2. Authorize Integration

- Go to the Utterances installation page and **authorize** the application to access your GitHub repository.

---

### 3. Inject Utterances Script in Your App

In your desired page or component (usually inside a `useEffect` for React apps), inject the Utterances script dynamically:

`useEffect(() => {`  
&nbsp;&nbsp;`const script = document.createElement('script')`  
&nbsp;&nbsp;`const anchor = document.getElementById('inject-comments-for-utterances')`  
&nbsp;&nbsp;`script.setAttribute('src', 'https://utteranc.es/client.js')`  
&nbsp;&nbsp;`script.setAttribute('crossorigin', 'anonymous')`  
&nbsp;&nbsp;`script.setAttribute('async', 'true')`  
&nbsp;&nbsp;`script.setAttribute('repo', 'your-username/your-repo')`  
&nbsp;&nbsp;`script.setAttribute('issue-term', 'pathname') // Can be 'title', 'url', etc.`  
&nbsp;&nbsp;`script.setAttribute('theme', 'github-dark')`  
&nbsp;&nbsp;`anchor?.appendChild(script)`  
`}, [])`

---

### 4. Define the Comment Container

Add this container where you want the comments to appear:

`<div id="inject-comments-for-utterances" style={{ width: '100%' }}></div>`

---

## REFERENCES

- Official Setup Guide: `https://utteranc.es/`
- GitHub Marketplace: `https://github.com/marketplace/utterances`
