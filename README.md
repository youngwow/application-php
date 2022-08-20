# application-php

Пишем роутер, класс, который будет стоять на входе в приложеньку и выяснять из урла, куда отдать управление.

Условия:

1. PHP8 (можно и 7.4, но проверять будем на 8.0-8.1)

2. Исходный относительный урл будет в переменной $pathText

3. Не забываем отфильтровать подозрительные символы

4. Алгоритм поиска класса/метода, куда отдать управление:
- если сегментов в урле меньше двух, то это потенциально имя класса, в таком случае проверяем наличие класса и пытаемся вызвать его метод index
- если сегментов меньше одного, то класс = Root, метод = index
- если сегментов два и больше, то, начиная с хвоста, ищем namespaced-класс, как только нашли - следующий сегмент - его метод, все последующие - параметры, которые надо передать в метод

5. Не падаем ни при каких условиях, любые варианты входных данных должны иметь обработчик

Например:

/ = Root->index()

/root/index = Root->index()

/server/api/json/commodities = \Server\Api\Json->commodities()

При наличии такого класса:

/server/api/json/commodities/12345/raw = \Server\Api\Json->commodities(['12345','raw'])

т.е. два последних сегмента отдаются обёрнутыми в массив параметром методу
