firstDishName = ["soup", "borsch", "cream-soup"]
secondDishName = ["porridge", "pilau"]
thirdDishName = ["compote", "tea", "jelly"]

firstDishPrice = [20, 24, 18]
secondDishPrice = [8, 9]
thirdDishPrice = [2, 3, 4]


def mix(a, b):
    [list1, list2] = [[*a] * len(b), [*b] * len(a)]
    list2.sort()
    return [list1, list2]


first = [*range(0, len(firstDishName))]
second = [*range(0, len(secondDishName))]
drinks = [*range(0, len(thirdDishName))]

[map1, map2] = mix(first, second)
[map1, map3] = mix(map1, drinks)
[map2, map3] = mix(map2, drinks)

i = 0
while i < len(map1):
    [fst, scd, thr] = [map1[i], map2[i], map3[i]]
    i = i + 1
    sum = firstDishPrice[fst] + secondDishPrice[scd] + thirdDishPrice[thr]
    if sum > 30:
        continue
    print('{} + {} + {} : {}'.format(firstDishName[fst], secondDishName[scd], thirdDishName[thr], sum))
