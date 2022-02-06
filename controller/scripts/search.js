function searchTable(index) {
    var input = document.getElementById('searchInput')
    var filter = input.value.toUpperCase()
    var table = document.getElementById('searchableTable')
    var tr = table.getElementsByTagName('tr')

    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName('td')[index]
        if (td) {
            var txtValue = td.textContent || td.innerText
            if (txtValue.indexOf(filter) > -1) {
                tr[i].style.display = ''
            } else {
                tr[i].style.display = 'none'
            }
        }
    }
}