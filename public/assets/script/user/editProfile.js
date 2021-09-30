$.fn.datepicker.dates["ru"] = {
  days: [
    "Воскресенье",
    "Понедельник",
    "Вторник",
    "Среда",
    "Четверг",
    "Птяница",
    "Суббота",
  ],
  daysShort: ["Вск", "Пнд", "Втн", "Срд", "Чтв", "Птн", "Суб"],
  daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
  months: [
    "Январь",
    "Февраль",
    "Март",
    "Апрель",
    "Май",
    "Июнь",
    "Июль",
    "Август",
    "Сентябрь",
    "Октябрь",
    "Ноябрь",
    "Декабрь",
  ],
  monthsShort: [
    "Янв",
    "Фев",
    "Мар",
    "Апр",
    "Май",
    "Июн",
    "Июл",
    "Авг",
    "Сен",
    "Окт",
    "Ноя",
    "Дек",
  ],
};

$(".date").datepicker({
  format: "dd MM yyyy",
  startDate: "01.01.1900",
  endDate: "01.01.2017",
  language: "ru",
  autoclose: true,
  clearBtn: true,
  orientation: "bottom auto",
  weekStart: 1,
});

$(".date")
  .datepicker()
  .on("show", function (e) {
    $(".datepicker").animate(
      {
        opacity: 1,
      },
      "slow"
    );
  });

$(".date")
  .datepicker()
  .on("hide", function (e) {
    $(".datepicker").animate(
      {
        opacity: 0,
      },
      "slow"
    );
  });
