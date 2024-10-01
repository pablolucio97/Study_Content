my_list = [1, 2, 3, "PS Code", True, False]
numbers_list = [1, 5, 2, 40, 44, 23]
ps_code_element = my_list[3]
list_slice = my_list[1:4]
list_slice_from_begin = my_list[:4]
my_list[4] = "replaced"
appended_list = my_list.append("Pablo")
element_index = my_list.index("Pablo")
inserted_element = my_list.insert(2, "Goal")
removed_element = my_list.pop(2)
numbers_list.sort()  # Sort the list in place

print("ps_code_element:", ps_code_element)
print("list_slice:", list_slice)
print("list_slice_from_begin:", list_slice_from_begin)
print("replaced_element_list:", my_list)
print("appended_list:", appended_list)  # This will print None, as append returns None
print("element_index:", element_index)
print("inserted_element:", inserted_element)  # This will print None, as insert returns None
print("removed_element:", removed_element)
print("sorted_numbers_list:", numbers_list)  # This will print the sorted list
