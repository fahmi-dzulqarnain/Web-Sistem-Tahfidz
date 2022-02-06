function filter(value, index, tableIndex) {
    const chips = document.querySelectorAll('.chip')
    chips.forEach(chip => chip.classList.remove('active'))
    chips[index].classList.add('active')

    var table = document.getElementById('searchableTable')
    var tr = table.getElementsByTagName('tr')

    if (value == 'semua') value = ''

    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName('td')[tableIndex]
        if (td) {
            var txtValue = td.textContent || td.innerText
            
            if (txtValue.indexOf(value) > -1) {
                tr[i].style.display = ''
            } else {
                tr[i].style.display = 'none'
            }
        }
    }
}