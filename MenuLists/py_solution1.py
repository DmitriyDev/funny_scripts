firstDishName = ["soup", "borsch", "cream-soup"]
secondDishName = ["porridge", "pilau"]
thirdDishName = ["compote", "tea", "jelly"]

firstDishPrice = [20, 24, 18]
secondDishPrice = [8, 9]
thirdDishPrice = [2, 3, 4]

fst = scd = thr = 0
while fst < len(firstDishPrice):
    sum = firstDishPrice[fst] + secondDishPrice[scd] + thirdDishPrice[thr]
    if sum <= 30:
        print('{} + {} + {} : {}'.format(firstDishName[fst], secondDishName[scd], thirdDishName[thr], sum))
    if thr == len(thirdDishPrice) - 1:
        thr = 0
        if scd == len(secondDishPrice) - 1:
            scd = 0
            fst = fst + 1
            continue
        scd = scd + 1
        continue
    thr = thr + 1