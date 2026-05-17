document.addEventListener("DOMContentLoaded", () => {
  const dropdownButton = document.getElementById("languageBtn");
  const languageList = document.getElementById("languageList");
  const arrowIcon = document.getElementById("arrowIcon");

  // Добавляем обработчик клика для кнопки
  dropdownButton.addEventListener("click", () => {
    toggleDropdown(languageList, arrowIcon);
  });

  // Закрытие дропдауна при клике вне
  document.addEventListener("click", (event) => {
    const isClickInside = dropdownButton.contains(event.target) || languageList.contains(event.target);
    if (!isClickInside) {
      closeDropdown(languageList, arrowIcon);
    }
  });

  // Закрытие дропдауна по клавише Escape
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeDropdown(languageList, arrowIcon);
    }
  });
});

// Функция для переключения состояния дропдауна
const toggleDropdown = (list, arrowIcon) => {
  if (list.classList.contains("open")) {
    closeDropdown(list, arrowIcon);
  } else {
    list.classList.add("open");
    arrowIcon.classList.add("rotate");
  }
};

// Функция для закрытия дропдауна
const closeDropdown = (list, arrowIcon) => {
  list.classList.remove("open");
  arrowIcon.classList.remove("rotate");
};
