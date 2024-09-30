complete_name = "Pablo Silva"
complete_name_line_break = "Pablo \ Silva"
name = "Pablo"
last_name = "Silva"

# Different ways to print variables:
print("Complete name:", complete_name)
print(f"Complete name: {complete_name}")
print("Complete name: %s" % complete_name)
print("Complete name: %s %s" % (name, last_name))
print("Complete name: {} {}".format(name, last_name))