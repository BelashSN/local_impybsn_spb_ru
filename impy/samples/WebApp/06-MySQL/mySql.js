// --------------------------- Переменные модуля
var jsonTable;
var sortRows;
// --------
var endRow = 0;
var lastRow = 0;
var firstRow = 0;
var pageSize = 5;
var totalRows = 0;
var filtredRows = 0;
var selectedRows = 0;
var pagination = true;
// --------
var sortOrdersRows = [];
sortOrdersRows.push(undefined);
sortOrdersRows.push({"name": "id", "sort": 1, "active": false});
sortOrdersRows.push({"name": "client", "sort": 1, "active": false});
sortOrdersRows.push({"name": "addres", "sort": 1, "active": false});
sortOrdersRows.push({"name": "created", "sort": 1, "active": false});
sortOrdersRows.push({"name": "closed", "sort": 1, "active": false});

// --------------------------- После полной загрузки страницы
$(document).ready(function() {
  $("#orders_delete").prop("disabled", true);
  $("#orders_navigator_selected").html("");
  $("#orders_result").html(""); /////-----
  $("#orders_result").css("background", "white"); /////----- 
  // --------------------
  jsonTable = getServerTable();
  updateOrdersData();

  // --------------------------- Клик на чекбокс шапки
  $("#orders tr th:nth-child(1) input[type='checkbox']").change(function() {
    // ------- пример для произвольной колонки (без :nth-child(1))
    // var index = $(this).closest("th").index();  
    // var selector = "#orders tr:visible td:nth-child(";
    // selector += (index + 1)+ ") input[type='checkbox']";
    // --------------------
    var selector = "#orders tr:visible td:nth-child(1) input[type='checkbox']";
    $(selector).prop("checked", this.checked);
    selectedRows = $(selector + ":checked").length;
    // --------------------
    updateOrdersView();
  });

  // --------------------------- Набор текста в строке поиска
  $("#orders_toolbar_search").on("input", filterOrdersRows);
  
  // --------------------------- Очистка текста в строке поиска по кнопке
  $("#orders_search_clear").click(() => {
    $("#orders_toolbar_search").val("");
    filterOrdersRows();
  });
  
  // --------------------------- Кнока наыигации по страницам - в начало
  $("#orders_navigator_start").click(() => {
    firstRow = 0;
    uncheckAllRows();
    filterOrdersRows();
  });
  
  // --------------------------- Кнока наыигации по страницам - предыдущая
  $("#orders_navigator_prev").click(() => {
    firstRow -= pageSize;
    firstRow = firstRow < 0 ? 0 : firstRow;
    uncheckAllRows();
    filterOrdersRows();
  });
  
  // --------------------------- Кнока наыигации по страницам - следующачя
  $("#orders_navigator_next").click(() => {
    firstRow += pageSize;
    firstRow = firstRow > lastRow ? lastRow : firstRow;
    uncheckAllRows();
    filterOrdersRows();
  });

  // --------------------------- Кнока наыигации по страницам - в конец
  $("#orders_navigator_end").click(() => {
    firstRow = lastRow;
    uncheckAllRows();
    filterOrdersRows();
  });
   
  // --------------------------- Кнока наыигации - по страницам или все
  $("#orders_navigator_type").click((e) => {
    firstRow = 0;
    pagination = !pagination;  
    // --------------------
    uncheckAllRows();
    filterOrdersRows();
  });
  
  // --------------------------- Клик по заголовку колонки - сортировка
  $("#orders th").click(function() {
    let ordersInd = $(this).closest("th").index();
    let ordersColl = sortOrdersRows[ordersInd];
    if(ordersColl === undefined) return;
    // --------------------    
    let wasAcrive = ordersColl.active;
    // -------------------- //? Оценить работу без цикла
    $.each(sortOrdersRows, function(index, value) {
      if(value !== undefined) value.active = false;
    });
    // --------------------
    ordersColl.active = true;
    if(wasAcrive) ordersColl.sort = ordersColl.sort > 0 ? -1 : 1;
    // --------------------
    let className = ordersColl.sort > 0 ? "asc" : "desc";
    $("#orders").find("th").removeClass("asc desc");
    $("#orders th").eq(ordersInd).addClass(className); 
    // --------------------
    jsonTable.sort(function(a, b) {
      var aSort = a[ordersColl.name], bSort= b[ordersColl.name];
      if(aSort == bSort) return 0;
      // --------------------
      if(ordersColl.sort > 0) return aSort > bSort ? 1: -1;
      else return aSort > bSort ? -1: 1;
    });
    // --------------------
    $("#orders").find("tr:gt(0)").remove();
    // --------------------
    uncheckAllRows();
    updateOrdersData();
  });
  
  // --------------------------- Кнопка - удалить выбранные строки
  $("#orders_delete").click(function(e) {
    e.preventDefault();
    var result = [];
    var message = "Будут удалены следующие заказы:\n\n";
    var selector = "#orders tr td:nth-child(1) input[type='checkbox']:checked";
    // --------------------
    $(selector).each(function() {
      var row = $(this).closest("tr")[0];
      result.push(row.cells[1].innerHTML);
      for(i = 1; i <= 3; i++) message += row.cells[i].innerHTML + "\n";
    });
    /////----- только в песочнице
    if (confirm(message + "\nПродолжить?")) { 
      $("#orders_result").html("Будет отправлено для удаления:<br><br>" 
      + JSON.stringify(result));
       $("#orders_result").css("background", "lightgrey");
    };
    /////-----
  });
  
  // --------------------------- Кнопка добавить новый заказ
  $("#orders_add").click(function(e) {
    e.preventDefault();   
    $(".orders_popup_bg").fadeIn(400);
    $("html").addClass(".orders_popup_show");
  });

  // --------------------------- Кнопки закрытия окна добавления заказа
  $(".orders_popup_close").click(function(e) {
    e.preventDefault();
    $(".orders_popup_bg").fadeOut(400);
    $("html").removeClass(".orders_popup_show");
  });
  
  // --------------------------- Кнопка - отправить новый заказ на сервер
  $("#orders_popup_submit").click(function(e) {
    e.preventDefault(); 
    var formDate = {};
    $("#orders_popup_form").find("input").each(function () {
      formDate[$(this).prop("name")] = $(this).val();
    });
    /////----- только в песочнице
    $("#orders_result").html("Будет отправлено для добавления:<br><br>" 
      + (JSON.stringify(formDate, null, "<br>"))); 
    $("#orders_result").css("background", "lightgrey");
    /////-----
    $(".orders_popup_bg").fadeOut(400);
    $("html").removeClass(".orders_popup_show");
    // -------------------- ? только при удаче
    $("#orders_popup_form input").val("");
  });
  
  // -------------------- /////----- только в песочнице
  $("#orders_result").click(function(e) {
    e.preventDefault();
    $("#orders_result").html("");
    $("#orders_result").css("background", "white");
  });
  // -------------------- /////-----
});
// --------------------------- Дополнительные функции

// --------------------------- Клик по чекбоксу в строке 
function onRowChecked(e) {
  selectedRows += e.checked ? 1 : -1;
  updateOrdersView();
}

// --------------------------- Обновтиь таблицу на странице из массива данных
function updateOrdersData(){
  let rowId = 0;
  // --------------------
  jsonTable.forEach((item) => {
    var trSel = "<tr><td><input type='checkbox' ";
    trSel += "onchange='onRowChecked(this)''/></td></tr>";
    var tr = $(trSel) .attr("id", "orders_row_" + rowId);
    // --------------------
    $("#orders_row_" + rowId).find("td").eq(0)
      .find("input").eq(0).attr("id", "orders_chek_" + rowId++);
    // --------------------
    Object.values(item).forEach((value) => 
      tr.append($("<td></td>").text(value)));
    $("#orders").append(tr);    
  });
  // --------------------
  totalRows = jsonTable.length;
  filterOrdersRows();
};

// --------------------------- фильтрация строк таблицы по строке поиска
function filterOrdersRows(){ 
  var $srchVal = $("#orders_toolbar_search").val().toLowerCase();
  // --------------------
  $("#orders").find("tr").each(function (rowIndex) {
    var $row = $(this);    
    // --------------------
    var valid = false;
    // --------------------
    var $cols = $row.find("td");    
    if($cols.length > 0) {           
      $cols.each(function () {
        var $col = $(this);               
        $col.html($col.html().replaceAll("<strong>", "").replaceAll("</strong>", ""));
        // --------------------
        var $colVal = $col.html().toLowerCase();
        // --------------------
        if($srchVal.length > 0) {
          var regex = new RegExp($srchVal, "gi");
          var regRes = $col.html().replace(regex, function(matched) {
              return "<strong>" + matched + "</strong>"; 
          });
          // --------------------
          $col.html(regRes);
        }
        // --------------------
        valid = valid || $colVal.indexOf($srchVal) >= 0;
      });
      // --------------------
      if(valid) $row.show();
      else $row.hide();
    };
  });
  // --------------------
  var curfiltred = $("#orders tbody tr:visible").length;
  if(curfiltred !== filtredRows){
    firstRow = 0;
    filtredRows = curfiltred;
    lastRow = filtredRows - filtredRows % pageSize; 
    uncheckAllRows();
  } 
  // --------------------
  paginateteOrders();
  updateOrdersView();
}

/// --------------------------- Отменить выбор всех чекбоксов строк
function uncheckAllRows(){
  var selector = "#orders tr th:nth-child(1) input[type='checkbox']";
  $(selector).prop("checked", false); 
  selector = "#orders tr td:nth-child(1) input[type='checkbox']";
  $(selector).prop("checked", false);
  selectedRows = 0;
}

// --------------------------- Обработка пагинации таблицы если включена
function paginateteOrders(){ 
  endRow = firstRow + pageSize - 1; 
  endRow = endRow >= filtredRows ? (filtredRows - 1) : endRow;
  endRow = pagination ? endRow : (filtredRows - 1); 
  // -------------
  if(!pagination) return;
  if(filtredRows <= pageSize) return;
  // -------------
  $("#orders tbody tr:visible").each(function(rowIndex) {
    if(rowIndex < firstRow) $(this).hide(); 
    if(rowIndex > endRow) $(this).hide();
  });
};

// --------------------------- Обновление оторажения и текстов после действий с таблицей
function updateOrdersView(){ 
  var startText = "Показано: " + (firstRow + 1) + " - " + (endRow + 1);
  $("#orders_navigator_total").html(startText + " из " + filtredRows);
  // -------------
  var selText = selectedRows === 0 ? "" : "Выделено: " + selectedRows ;
  $("#orders_navigator_selected").html(selText);
  // -------------
  $("#orders_delete").prop("disabled", selectedRows === 0);
  // -------------
  $("#orders tbody tr").removeClass("orders_rows_odd orders_rows_even");
  $("#orders tbody tr:visible:odd").addClass("orders_rows_odd");
  $("#orders tbody tr:visible:even").addClass("orders_rows_even");       
  // --------------------
  let btnText = pagination ? "Показать все" : "Показать по " + pageSize;
  $("#orders_navigator_type").html(btnText);
  // -------------
  $(".nav_buttons").removeClass("orders_navigator_disabled");
  if(!pagination) $(".nav_buttons").addClass("orders_navigator_disabled");  
  if(firstRow <= 0){
    $("#orders_navigator_start").addClass("orders_navigator_disabled");
    $("#orders_navigator_prev").addClass("orders_navigator_disabled");
  } 
  if(firstRow >= lastRow){
    $("#orders_navigator_next").addClass("orders_navigator_disabled");
    $("#orders_navigator_end").addClass("orders_navigator_disabled");
  }  
};



// --------------------------- Получение массива данных - только песочница
function getServerTable(){
  var json = '[{"id": 15, "client": "Петров Иван Викторович",';
  json += ' "addres": "Москва, Цветной бульвар, 4, 45",';
  json += ' "created": "2025-06-05", "closed": "2025-06-09"},';
  json += ' {"id": 16, "client": "Пугачева Алла Максимовна",';
  json += ' "addres": "Грязь, Кривая ул, 1, 2",';
  json += ' "created": "2025-06-09", "closed": ""},';
  json += ' {"id": 17, "client": "Засранченко Тарас Бульбович",';
  json += ' "addres": "Барнаул, Угловая ул, 14, 3",';
  json += ' "created": "2025-06-09", "closed": "2025-06-15"},';
  json += ' {"id": 18, "client": "Сидоров Петр Иннокентьевич",';
  json += ' "addres": "Санкт-Петербург, Невский проспект, 210, 36",';
  json += ' "created": "2025-06-11", "closed": "2025-06-19"},';
  json += ' {"id": 19, "client": "Андреев Никанор Липатович",';
  json += ' "addres": "Владивосток, Главная ул, 101, 131",';
  json += ' "created": "2025-06-12", "closed": ""},';
  json += ' {"id": 20, "client": "Рабинович Мойша Моисеевич",';
  json += ' "addres": "Псков, Псковская ул, 22, 42",';
  json += ' "created": "2025-06-15", "closed": ""},';
  json += ' {"id": 21, "client": "Кукушкина Василиса Никодимовна",';
  json += ' "addres": "Москва, Западная ул. , 91, 83",';
  json += ' "created": "2025-06-11", "closed": ""},';
  json += ' {"id": 22, "client": "Мамонтов Геннадий Егорович",';
  json += ' "addres": "Сочи, Морская ул, 61, 75",';
  json += ' "created": "2025-06-12", "closed": ""}]';

  return JSON.parse(json);
};
