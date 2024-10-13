# UBUNTU LINUX SERVER COMMANDS

- `sudo adduser your_user_name`: Creates a new user for the OS.
- `sudo usermod -aG sudo your_user_name`: Adds sudo permissions to the created user.
- `sudo su -app`: Logs in as the created user.
- `mkdir your_directory_name`: Creates a directory.
- `rm -r your_directory_name`: Deletes a directory.
- `rm -rf your_directory_name`: Deletes a directory without confirmation.
- `export YOUR_VARIABLE_NAME=your_variable_value`: Creates an environment variable.
- `cd your_directory_name`: Navigates to a directory.
- `cd`: Goes back to the default server directory.
- `cd ..`: Goes back to the previous directory.
- `cp file_name new_file_name`: Renames a file.
- `ssh-keygen`: Generates a new SSH key (provide a name for the key when prompted).
- `cat your_sshkey.pub`: Reads/copies the new SSH key.
- `sudo apt install the_pack_name`: Installs a package directly in the OS.
- `cd /etc/pack_name`: Accesses a package's folder.
- `sudo -i`: Logs in as root on Ubuntu (grants more permissions).
  
## Editing a File
1. Run `vim your_file.extension`.
2. Type `/desired_string` to search for the string.
3. Press `i` to edit.
4. When finished, press `Esc` and type `:wq!` to save and exit.

# GENERAL TIPS

- Log in as **root** to have full user access.
- Use the **sudo** prefix to grant permissions for administrative commands.
