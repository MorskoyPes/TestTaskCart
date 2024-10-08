## AddToCartController

### Проблемы:
1. **Толстый контроллер**: Контроллер содержит бизнес логику вместо того, чтобы работать только с запросами и ответами
2. **Нарушение принципа единственной ответственности**: Вся логика должна быть вынесена в сервисный слой

### Исправления:
1. **Вынесение логики в сервис**: Новый сервис `CartService` отвечает за логику и работу с репозиториями
2. **Упрощение контроллера**: Контроллер занимается только обработкой запроса и передачей данных в сервис
3. **Использование DDD**: Логика корзины теперь находится в сервисе
4. **Добавление проверки**: Если не найдена корзина теперь возвращается 404 ответ

## GetCartController

### Проблемы:
1. **Толстый контроллер**: Контроллер содержит логику получения корзины
2. **Неправильный статус ответа**: При обработке запроса возвращается статус 404 вместо успешного 200

### Исправления:
1. **Вынесение бизнес-логики в CartService**: Логика вынесена в `CartService`
2. **Корректный статус ответа**: При успешном выполнении запроса возвращается статус 200

## ConnectorFacade

### Проблемы:
1. **Отсутствие логирования ошибок**: Не было логирования

### Исправления:
1. **Добавлено логирование ошибок**: Появилось логирование ошибок подключения к базе редиса

## Product

### Проблемы:
1. **Неправильное расположение сущности**: Сущность `Product` находилась в пространстве имен `Repository\Entity`

### Исправления:
1. **Перемещение в домен**: Сущность `Product` была перемещена в папку `Domain\Entity`
2. **Иправление пространств имен**: Исправлены пути до сущности и пространств имен в `ProductsView` и `Product`

## ProductRepository

### Проблемы:
1. **Уязвимость к SQL-инъекциям**: Строки запроса SQL были уязвимы для SQL-инъекций
2. **Неправильное пространство имен сущности**: Устаревшее расположение сущности `Product`

### Исправления:
1. **Использование подготовленных выражений**: Запросы используют подготовленные выражения

## CartView

### Проблемы:
1. **Логика в представлении**: В `CartView` содержалась логика

### Исправления:
1. **Вынесение логики в CartService**: Логика получения данных находится в `CartService`

## Cart CartItem Customer 

### Проблемы:
1. **Файлы без определения директории**: Файлы находятся в папке Domain и не понятно к чему они пренадлежат

### Исправления:
1. **Перемещение в Entity**: Теперь все модели лежат в поддиректории Entity