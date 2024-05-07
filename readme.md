# Лаб ООП
Реалізувати телеграм-бота зі збору вакансій з різних платформ (linked-in, telegram канали, djini)
# ЛАБ 3
Написати програмне забезпечення, що описує застосування породжуючий патерн
- Стратегія (Strategy).

Реалізувати інтерактивне меню для бота, з можливістю підписатися на канал в тг, підписатися на пошук в linkedIn або djini, кнопки назад і головне меню, перегляду активних підписок:
для реалізації створити абстрактний клас ```GlobalKeyboardCommandEvent``` з абстракним методом executeCommand, і  наслідники для цього класу з відповідними реалзаціями для кожної кнопки меню,
в executeCommand описати відповідну повіедінки для кожної кнопки
Створити ```GlobalEventHandler``` з методом handle який як вхідний параметр приймає ```GlobalKeyboardCommandEvent``` і викликати ```executeCommand``` з вхідного обєкта
```
public function handle(GlobalKeyboardCommandEvent $event)
{
    $event->executeCommand();
}
```