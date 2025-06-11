function doPost(e) {
  var ss = SpreadsheetApp.openById("PASTE_YOUR_SHEET_ID");
  var sheet = ss.getSheetByName("Sheet1");
  sheet.appendRow([new Date(), e.parameter.ip, e.parameter.name, e.parameter.email]);
  return ContentService.createTextOutput("OK");
}
