my_list = [1,2,3,4]

for my_list_el in my_list:
    print("Double list: ", my_list_el * 2)



my_tuple = (1,2,3,4)

for my_tuple_el in my_tuple:
    print("Double tuple:", my_tuple_el * 2)



people_dict = {"name": "Pablo", "age" : 29, "developer" : True}

for people_dict_key in people_dict.keys():
    print("People dict key: ", people_dict_key)

for people_dict_item in people_dict.items():
    print("People dict item: ", people_dict_item)


numbers_range = list(range(0,10)) #range() method creates a numeric array according the informed params

for number_el in numbers_range:
    print("Number el:", number_el) 


list_base = [1,2,3,4,5,6]
list_length = len(list_base)
list_range = range(0, len(list_base)) #len() method returns the list length

for list_el in list_range:
    print("list_el:", list_el)
    print("list_index:", list_range[list_el])


list_enumerate = ["a", "b", "c"]
for index, value in enumerate(list_enumerate): #enumerate() method returns a list as an object assigning key value pairs
    print(f"{index}: {value}")

