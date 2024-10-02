people_dict = {"name": "Pablo", "age" : 29, "developer" : True}
# people_dict2 = {"name": "Camilla", "age" : 29, "developer" : False}

people_name = people_dict["name"]
people_age = people_dict["age"]
people_developer = people_dict["developer"]

print("people_dict: ", people_dict)
print("people_name: ", people_name)
print("people_age: ", people_age)
print("people_developer: ", people_developer)

people_new_value = people_dict["city"] = "João Monlevade"
print("people_dict", people_dict)

# composed_dict = people_dict["new_dict"] = people_dict2
# print("composed_dict", composed_dict)

people_updated_age = people_dict["updated_age"] = 31
print("people_dict: ", people_dict)

# del keyword
del people_dict["updated_age"]
print("people_dict with updated_age removed: ", people_dict)

# .keys() methods
people_dict_keys = list(people_dict.keys())
print("people_dict keys: ", people_dict_keys)

# .values() method
people_dict_values = list(people_dict.values())
print("people_dict values: ", people_dict_values)

people_dict_age_value = people_dict_values[1]
print("people_dict age value: ", people_dict_age_value)

# .items() method
people_dict_items = list(people_dict.items())
print("people_dict items: ", people_dict_items)

people_dict_first_tuple = people_dict_items[0]
print("people_dict_first_tuple: ", people_dict_first_tuple)

people_dict_first_tuple_key = people_dict_items[0][0]
print("people_dict_first_tuple_key: ", people_dict_first_tuple_key)

people_dict_first_tuple_value = people_dict_items[0][1]
print("people_dict_first_tuple_value: ", people_dict_first_tuple_value)



