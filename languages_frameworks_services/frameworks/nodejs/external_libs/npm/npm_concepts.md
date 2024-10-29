# NPM Concepts

NPM, or **Node Package Manager**, is used to fetch packages for a project, integrate them, or publish your own project for broader use.

You can start a new project by running `npm init -y`, which will generate a `package.json` file in your project’s root folder. It will look something like this:

`{ "name": "psd-react-component-test", "version": "1.0.0", "description": "", "main": "index.js", "scripts": { "test": "echo \"Error: no test specified\" && exit 1", "build": "rollup -c", "start": "rollup -c -w" }, "keywords": [], "author": "", "license": "ISC", "devDependencies": { "@types/react": "^18.0.11", "@types/react-dom": "^18.0.5", "babel-core": "^6.26.3", "babel-runtime": "^6.26.0", "react": "17.0.2", "rollup": "^2.75.5", "rollup-plugin-sass": "^1.2.12", "rollup-plugin-typescript2": "^0.32.0", "typescript": "^4.7.3" } }`

### Package.json fields:

- **name**: Your project name.
- **version**: Current version of your project, following `major.minor.patch`. Update `patch` for bug fixes, `minor` for new features, and `major` if breaking changes are introduced.
- **description**: Brief description of your project.
- **main**: Path to the main distribution file/folder.
- **scripts**: Scripts to automate tasks in the project.
- **keywords**: Keywords that describe your project.
- **author**: Author of the project.
- **license**: Project’s license.
- **devDependencies**: Development dependencies of the project. When publishing a package, install all dependencies as devDependencies.

---

## General Tips

- Use `npm install --legacy-peer-deps --force` to install deprecated libraries in legacy projects while keeping existing dependencies stable (avoiding automatic updates).
  
- Use the import syntax `import * as something from 'somewhere'` if a third-party library lacks a default export.

- Always create an `.npmrc` file with `save-exact=true` in each project to install dependencies at an exact version, enabling GitHub bots (like Renovate) to track and suggest dependency updates without causing version conflicts.

- The `--` flag after `npm` indicates that any following arguments are flags for the CLI command you're running, not for npm.

- The `pre` and `post` prefixes in script names denote tasks that should run before or after the main script, respectively.

- If cloning a repo and mixing it into a current project, verify that new files work correctly by running `npx yarn tsc --noEmit` (if the project uses TypeScript).
