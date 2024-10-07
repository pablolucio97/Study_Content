#For use third modules you must:
# 1 - Install the library running the command ex:`pip3 install requests`
# 2 - Import the library or the method you will use.
# Obs: You can check if the library was installed correctly running `pip3 list` command and you can install a specific version running by example: `pip3 install requests==2.31.0``.

from requests import get
url = "http://localhost:3335/users/get"
response = get(url)
print(f"The response status code for {url} was {response.status_code}")