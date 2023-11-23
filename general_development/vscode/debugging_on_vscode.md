# Debugging Node.js Applications

Debugging is a more efficient way to discover bugs in your code.

1. **Setting Up Debug in VS Code:**
   - In VS Code, click on the Bug Icon in the left vertical bar and select "Run". VS Code will create a new `.vscode` folder in your project.

2. **Configuring launch.json:**
   - Access the `launch.json` file inside the `.vscode` folder and change the configurations to:
     ```json
     {
         "version": "0.2.0",
         "configurations": [
             {
                 "type": "node",
                 "request": "attach",
                 "name": "Launch Program",
                 "skipFiles": [
                     "<node_internals>/**"
                 ],
                 "outFiles": [
                     "${workspaceFolder}/**/*.js"
                 ]
             }
         ]
     }
     ```

3. **Updating package.json:**
   - Edit the `dev` script in `package.json`, adding the `--inspect` flag. For example:
     ```json
     "scripts": {
         "dev": "ts-node-dev --inspect --transpile-only --ignore-watch node_modules --respawn src/server.ts"
     }
     ```

4. **Starting Debugging:**
   - Click on "Run" again (Bug Icon), and select "Launch Program" to start debugging.

5. **Debugging a Specific File:**
   - In the file you want to debug, select the line you desire to investigate and call your function. VS Code will highlight the line where the error is and will indicate the reason for the error.
