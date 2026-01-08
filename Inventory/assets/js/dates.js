/**
 * @param {number} year  - e.g. 2026
 * @param {number} month - 1-based (1 = January, 12 = December)
 * @returns {string[]}   - ['YYYY-MM-DD', ...]
 */
function getDates(year, month) {
    // Convert to JS 0-based month
    const jsMonth = month - 1;

    const daysInMonth = new Date(year, jsMonth + 1, 0).getDate();
    const dates = [];

    for (let day = 1; day <= daysInMonth; day++) {
        const yyyy = year;
        const mm = String(month).padStart(2, '0');
        const dd = String(day).padStart(2, '0');

        dates.push(`${yyyy}-${mm}-${dd}`);
    }
    return dates;
}

function formatDateToMonthDay(dateStr) {
  const [year, month, day] = dateStr.split('-').map(Number);

  const date = new Date(year, month - 1, day);

  return date.toLocaleString('en-US', {
    month: 'short',
    day: 'numeric'
  });
}

function getAllMonths() {
  const months = [];
  for (let month = 0; month < 12; month++) {
    const date = new Date(2000, month, 1); // year doesn't matter
    const monthName = date.toLocaleString('default', { month: 'long' });
    months.push(monthName);
  }
  return months;
}

function getLastTenYears() {
  const currentYear = new Date().getFullYear();
  const years = [];

  for (let i = currentYear - 20; i <= currentYear; i++) {
    years.push(i);
  }

  return years;
}



var selection_months_text = document.getElementsByClassName("months_text") ? document.getElementsByClassName("months_text") : [];
for (let index = 0; index < selection_months_text.length; index++) {
    getAllMonths().forEach(month => {
        var opt = document.createElement("option")
        opt.innerText = month
        opt.value = month
        if(new Date().toLocaleString('en-US', { month: 'long' }) == month){
            opt.selected = true
        }
        selection_months_text[index].appendChild(opt)
    })
}

var selection_months_number = document.getElementsByClassName("months_number") ? document.getElementsByClassName("months_number") : [];

for (let index = 0; index < selection_months_number.length; index++) {
    getAllMonths().forEach((month, monthIndex) => {
        var opt = document.createElement("option");
        opt.innerText = month;
        opt.value = monthIndex + 1; // January = 1, February = 2, etc.

        if (new Date().toLocaleString('en-US', { month: 'long' }) === month) {
            opt.selected = true;
        }

        selection_months_number[index].appendChild(opt);
    });
}


var selection_years = document.getElementsByClassName("years");
for (let index = 0; index < selection_years.length; index++) {
    getLastTenYears().forEach(year => {
        var opt = document.createElement("option")
        opt.innerText = year
        opt.value = year
        if(new Date().getFullYear() == year){
            opt.selected = true
        }
        selection_years[index].appendChild(opt)
    })
}
