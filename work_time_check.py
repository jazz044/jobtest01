import sys
from datetime import datetime, timedelta

from PySide6.QtWidgets import (
    QApplication, QMainWindow, QVBoxLayout, QWidget, QPushButton, QLineEdit,
    QLabel, QTableWidget, QTableWidgetItem, QHeaderView, QDateEdit, QComboBox,
    QDialog, QTabWidget, QMessageBox
)
from PySide6.QtCore import Qt, QDate

import sqlite3



# Функция для подключения к базе данных
def connect_db():
    conn = sqlite3.connect("work_time.db")
    cursor = conn.cursor()
    return conn, cursor


# Инициализация базы данных
def init_db():
    conn, cursor = connect_db()

    # SQL-код для создания таблиц
    create_tables_sql = """
    CREATE TABLE IF NOT EXISTS employees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE
    );

    CREATE TABLE IF NOT EXISTS time_records (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        employee_id INTEGER NOT NULL,
        date DATE NOT NULL,
        hours_worked REAL NOT NULL,
        FOREIGN KEY (employee_id) REFERENCES employees(id)
    );
    """

    # Выполнение SQL-скрипта
    cursor.executescript(create_tables_sql)
    conn.commit()
    conn.close()


class StatisticsDialog(QDialog):
    """Диалоговое окно для отображения статистики."""

    def __init__(self, daily_stats, weekly_stats, monthly_stats):
        super().__init__()

        self.setWindowTitle("Статистика")
        self.setGeometry(200, 200, 600, 400)

        # Создаем вкладки для разных периодов
        tab_widget = QTabWidget()

        # Таблица для статистики за день
        daily_table = self.create_stats_table(daily_stats)
        tab_widget.addTab(daily_table, "Статистика за день")

        # Таблица для статистики за неделю
        weekly_table = self.create_stats_table(weekly_stats)
        tab_widget.addTab(weekly_table, "Статистика за неделю")

        # Таблица для статистики за месяц
        monthly_table = self.create_stats_table(monthly_stats)
        tab_widget.addTab(monthly_table, "Статистика за месяц")

        # Главный макет
        layout = QVBoxLayout()
        layout.addWidget(tab_widget)
        self.setLayout(layout)

    def create_stats_table(self, stats_data):
        """Создает таблицу для отображения статистики."""
        table = QTableWidget()
        table.setColumnCount(2)
        table.setHorizontalHeaderLabels(["Сотрудник", "Часы"])
        table.horizontalHeader().setSectionResizeMode(QHeaderView.Stretch)

        for row, (name, hours) in enumerate(stats_data):
            table.insertRow(row)
            table.setItem(row, 0, QTableWidgetItem(name))
            table.setItem(row, 1, QTableWidgetItem(str(hours)))

        return table


# Класс главного окна
class WorkTimeApp(QMainWindow):
    def __init__(self):
        super().__init__()

        self.setWindowTitle("Отслеживание рабочего времени")
        self.setGeometry(100, 100, 800, 600)

        # Главный контейнер
        container = QWidget()
        layout = QVBoxLayout()

        # Виджеты для добавления сотрудника
        self.employee_name_input = QLineEdit()
        self.employee_name_input.setPlaceholderText("Имя сотрудника")
        add_employee_button = QPushButton("Добавить сотрудника")
        add_employee_button.clicked.connect(self.add_employee)

        # Виджеты для добавления записи о времени
        self.employee_combo = QComboBox()
        self.update_employee_list()  # Загрузка списка сотрудников
        self.date_edit = QDateEdit(calendarPopup=True)
        self.date_edit.setDate(QDate.currentDate())
        self.hours_input = QLineEdit()
        self.hours_input.setPlaceholderText("Количество часов")
        add_record_button = QPushButton("Добавить запись")
        add_record_button.clicked.connect(self.add_time_record)

        # Таблица для просмотра записей
        self.table = QTableWidget()
        self.table.setColumnCount(4)
        self.table.setHorizontalHeaderLabels(["Сотрудник", "Дата", "Часы", ""])
        self.table.horizontalHeader().setSectionResizeMode(QHeaderView.Stretch)

        # Кнопка для просмотра статистики
        stats_button = QPushButton("Просмотреть статистику")
        stats_button.clicked.connect(self.show_statistics)

        # Кнопка для обнуления данных
        reset_button = QPushButton("Обнулить данные")
        reset_button.clicked.connect(self.reset_data)

        # Добавление виджетов в макет
        layout.addWidget(QLabel("Добавить сотрудника:"))
        layout.addWidget(self.employee_name_input)
        layout.addWidget(add_employee_button)

        layout.addWidget(QLabel("Добавить запись о времени:"))
        layout.addWidget(QLabel("Сотрудник:"))
        layout.addWidget(self.employee_combo)
        layout.addWidget(QLabel("Дата:"))
        layout.addWidget(self.date_edit)
        layout.addWidget(QLabel("Часы:"))
        layout.addWidget(self.hours_input)
        layout.addWidget(add_record_button)

        layout.addWidget(QLabel("Записи:"))
        layout.addWidget(self.table)

        layout.addWidget(stats_button)
        layout.addWidget(reset_button)

        container.setLayout(layout)
        self.setCentralWidget(container)

    def update_employee_list(self):
        """Обновляет список сотрудников в ComboBox."""
        conn, cursor = connect_db()
        cursor.execute("SELECT id, name FROM employees")
        employees = cursor.fetchall()
        conn.close()

        self.employee_combo.clear()
        for emp_id, name in employees:
            self.employee_combo.addItem(name, emp_id)

    def add_employee(self):
        """Добавляет нового сотрудника в базу данных."""
        name = self.employee_name_input.text().strip()
        if not name:
            return

        conn, cursor = connect_db()
        try:
            cursor.execute("INSERT INTO employees (name) VALUES (?)", (name,))
            conn.commit()
            self.update_employee_list()
            self.employee_name_input.clear()
        except sqlite3.IntegrityError:
            print("Сотрудник с таким именем уже существует.")
        finally:
            conn.close()

    def add_time_record(self):
        """Добавляет новую запись о времени работы."""
        employee_id = self.employee_combo.currentData()
        date = self.date_edit.date().toString(Qt.ISODate)
        hours = self.hours_input.text().strip()

        if not employee_id or not hours:
            return

        conn, cursor = connect_db()
        cursor.execute(
            "INSERT INTO time_records (employee_id, date, hours_worked) VALUES (?, ?, ?)",
            (employee_id, date, float(hours))
        )
        conn.commit()
        conn.close()

        self.load_records()
        self.hours_input.clear()

    def load_records(self):
        """Загружает записи из базы данных в таблицу."""
        conn, cursor = connect_db()
        cursor.execute("""
            SELECT e.name, t.date, t.hours_worked
            FROM time_records t
            JOIN employees e ON t.employee_id = e.id
        """)
        records = cursor.fetchall()
        conn.close()

        self.table.setRowCount(len(records))
        for row, (name, date, hours) in enumerate(records):
            self.table.setItem(row, 0, QTableWidgetItem(name))
            self.table.setItem(row, 1, QTableWidgetItem(date))
            self.table.setItem(row, 2, QTableWidgetItem(str(hours)))

    def show_statistics(self):
        """Показывает статистику в диалоговом окне."""
        conn, cursor = connect_db()

        # Статистика за день
        today = datetime.now().strftime("%Y-%m-%d")
        cursor.execute("""
            SELECT e.name, SUM(t.hours_worked)
            FROM time_records t
            JOIN employees e ON t.employee_id = e.id
            WHERE t.date = ?
            GROUP BY e.name
        """, (today,))
        daily_stats = cursor.fetchall()

        # Статистика за неделю
        week_start = (datetime.now() - timedelta(days=datetime.now().weekday())).strftime("%Y-%m-%d")
        cursor.execute("""
            SELECT e.name, SUM(t.hours_worked)
            FROM time_records t
            JOIN employees e ON t.employee_id = e.id
            WHERE t.date >= ?
            GROUP BY e.name
        """, (week_start,))
        weekly_stats = cursor.fetchall()

        # Статистика за месяц
        month_start = datetime.now().replace(day=1).strftime("%Y-%m-%d")
        cursor.execute("""
            SELECT e.name, SUM(t.hours_worked)
            FROM time_records t
            JOIN employees e ON t.employee_id = e.id
            WHERE t.date >= ?
            GROUP BY e.name
        """, (month_start,))
        monthly_stats = cursor.fetchall()

        conn.close()

        # Открываем диалоговое окно со статистикой
        dialog = StatisticsDialog(daily_stats, weekly_stats, monthly_stats)
        dialog.exec()

    def reset_data(self):
        """Обнуляет все данные в базе данных."""
        confirm = QMessageBox.question(
            self,
            "Подтверждение",
            "Вы уверены, что хотите удалить все данные?",
            QMessageBox.Yes | QMessageBox.No
        )

        if confirm == QMessageBox.Yes:
            conn, cursor = connect_db()
            try:
                # Удаляем все записи о времени работы
                cursor.execute("DELETE FROM time_records")
                # Удаляем всех сотрудников
                cursor.execute("DELETE FROM employees")
                conn.commit()

                # Обновляем интерфейс
                self.update_employee_list()
                self.load_records()

                QMessageBox.information(self, "Успешно", "Все данные были успешно удалены.")
            except Exception as e:
                QMessageBox.critical(self, "Ошибка", f"Не удалось обнулить данные: {str(e)}")
            finally:
                conn.close()


if __name__ == "__main__":
    init_db()  # Инициализация базы данных
    app = QApplication(sys.argv)

    # Установка стиля Fusion для лучшего контроля над виджетами
    app.setStyle("Fusion")

    # Применение глобального стиля для удаления обводки
    app.setStyleSheet("""
        QLineEdit:focus, QComboBox:focus, QTableWidget:focus {
            border: none;
            outline: none;
        }
        QLineEdit, QComboBox {
            border: 1px solid #ccc;  /* Светлая граница в нормальном состоянии */
        }
    """)


    window = WorkTimeApp()
    window.show()
    sys.exit(app.exec())

