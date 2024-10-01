complete_name = "xPablo Silva"

upperName = complete_name.upper()
lowerName = complete_name.lower()
countA = complete_name.count("l")
findFirstIndex = complete_name.find("l")
encodedName = complete_name.encode()  #was encoded in bytes
rawName = complete_name.encode().decode() #was encoded in bytes and return to string again
replacedName = complete_name.replace("a", "o")
separatedName = "-".join(complete_name)
splittedName = complete_name.split(" ")
strippedName = complete_name.strip("x")
startsWith = complete_name.startswith("xPab")
findInName = "blo" in complete_name
notFindInName = "blo" not in complete_name

firstLetter = complete_name[0]
lastLetter = complete_name[-1]

print("upperName: ", upperName)
print("lowerName: ", lowerName)
print("firstLetter: ", firstLetter)
print("lastLetter: ", lastLetter)
print("countA: ", countA)
print("findFirstIndex: ", findFirstIndex)
print("encodedName: ", encodedName)
print("rawName: ", rawName)
print("replacedName: ", replacedName)
print("separatedName: ", separatedName)
print("splittedName: ", splittedName)
print("splittedName: ", splittedName)
print("strippedName: ", strippedName)
print("startsWith: ", startsWith)
print("findInName: ", findInName)
print("notFindInName: ", notFindInName)

