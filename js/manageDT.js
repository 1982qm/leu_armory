//-----------------------------------------------------------------------------
// CREAZIONE DATATABLE
//-----------------------------------------------------------------------------
function CreateDataTable(myDt, addFun, editFun, delFun) {
    var buttons = [];
    if (addFun != undefined) {
        buttons.push(
            {
                text: 'Nuova Build',
                className: 'customButton btn btn-primary btn-sm',
                action: function (e, dt, node, config) {
                    addFun(dt);
                }
            }
        )
    };
    if (editFun != undefined) {
        buttons.push(
            {
                text: 'Modifica',
                className: 'customButton btn btn-primary btn-sm',
                action: function (e, dt, node, config) {
                    editFun(dt);
                }
            }
        )
    };
    if (delFun != undefined) {
        buttons.push(
            {
                text: 'Elimina',
                className: 'customButton btn btn-danger btn-sm',
                action: function (e, dt, node, config) {
                    delFun(dt);
                }
            }
        )
    };

    // Creo la tabella
    var table = $(myDt).DataTable({
        // Abilito la selezione del record
        //select: true,
        // Abilito il responsive (per la disposizione automatica)
        responsive: true,
        // Visualizzo 20 righe per pagina
        iDisplayLength: 20,
        // Allineo tutti i campi a sinistra
        columnDefs: [
            //{ width: '50%', targets: 0 },
            { className: 'dt-left', targets: '_all' },
        ],
        // Aggiungo i bottoni di editing
        layout: {
            topStart: {
                buttons: buttons
            }
        },
        // Setto la lingua 
        language: {
            url: "/armory/lib/datatable_it-IT.json"
        },
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    let column = this;
                    let title = column.footer().textContent;

                    // Create input element
                    let input = document.createElement('input');
                    input.placeholder = title;
                    input.classList.add("searchInput");
                    column.footer().replaceChildren(input);

                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    });
                });
            // Rimuovo la classe di default del dataTable
            $(".customButton").parent().removeClass("dt-buttons");
        }
    });

    return table;
}

//-----------------------------------------------------------------------------
// CARICAMENTO DATATABLE, SI ASPETTA SEMPRE DUE CAMPI: ID E NAME
//-----------------------------------------------------------------------------
function LoadDataTable(myDt, array, makeRow, clickFun) {
    // Pulizia dataTable
    var dtTable = $(myDt).DataTable();
    dtTable.clear();
    // Caricamento dataTable
    array.forEach(
        element => {
            // Aggiungo la riga alla griglia
            var row = makeRow(element);
            dtTable.row.add(row);
        }
    );
    if (clickFun != undefined) {
        // Elimino eventuali eventi dbclick già registrati
        $(myDt).find('tbody').off('click', 'tr');
        // Ad ogni riga associo un evento dbclick per editare il record
        $(myDt).find('tbody').on('click', 'tr', function () {
            // Deseleziono eventuali righe già selezionate
            //$(".selected").removeClass("selected");
            // Seleziono il record sul quale è stato eseguito il dbclick
            var tr = dtTable.row(this).node();
            //tr.classList.add('selected');
            // Mostro la form di editing del record
            clickFun(tr);
        });
    };
    // Rendering del dataTable
    dtTable.columns.adjust().draw(false);

    return dtTable;
}