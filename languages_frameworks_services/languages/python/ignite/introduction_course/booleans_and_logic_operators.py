if True:
    print("Block will be executed when truth")
else:
    print("Block will not be executed")

if True and True:
    print("Block will be executed when truth and truth")
elif True and False:
    print("Block will not be executed")
else:
    print("Block will not be executed")

if True or False:
    print("Block will be executed when truth or falsy")