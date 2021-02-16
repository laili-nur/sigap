<style>
/* 
/* javascript */

/* .add,
.cut {
    border-width: 1px;
    display: block;
    font-size: .8rem;
    padding: 0.25em 0.5em;
    float: left;
    text-align: center;
    width: 0.6em;
}

.add,
.cut {
    background: #9AF;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
    background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
    border-radius: 0.5em;
    border-color: #0076A3;
    color: #FFF;
    cursor: pointer;
    font-weight: bold;
    text-shadow: 0 -1px 2px rgba(0, 0, 0, 0.333);
}

.add {
    margin: -2.5em 0 0;
}

.add:hover {
    background: #00ADEE;
}

.cut {
    opacity: 0;
    position: absolute;
    top: 0;
    left: -1.5em;
}

.cut {
    -webkit-transition: opacity 100ms ease-in;
}

tr:hover .cut {
    opacity: 1;
}
 */
</style>
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('logistic_purchase'); ?>">Pembelian Logistik</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-12">
            <section class="card col-md-8">
                <div class="card-body">
                    <form action="<?= base_url("logistic_purchase/add_logisticpurchase"); ?>" method="post">
                        <fieldset>
                            <legend>Form Pembelian Logistik</legend>

                            <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css"
                                rel="stylesheet"><!-- JQuery UI CSS -->
                            <div class="form-group">
                                <div id="prefetch">
                                    <label for="book_title" class="font-weight-bold">Kode Pembelian<abbr
                                            title="Required">*</abbr></label>
                                    <input type="text" name="book_title" id="book_title" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order_number" class="font-weight-bold">Tanggal Pembelian<abbr
                                        title="Required">*</abbr></label>
                                <input type="date" name="order_number" id="order_number" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="total" class="font-weight-bold">List Pembelian Logistik<abbr
                                        title="Required">*</abbr></label>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <p class="m-0">Nama Logistik</p>
                                        <select class="form-control" name="logistic_name" id="logistic_name">
                                            <option value="" selected="selected">-- Pilih --</option>
                                            <option value="HVS 70">HVS 70</option>
                                            <option value="Pulpen">Pulpen </option>
                                            <option value="Pensil">Pensil</option>
                                            <option value="Penghapus">Penghapus</option>
                                            <option value="Stepler">Stepler</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <p class="m-0">Jumlah</p>
                                        <input type="number" class="form-control" style="max-width: auto;" name="qty"
                                            id="qty">
                                    </div>
                                    <div class="col-2">
                                        <br>
                                        <input class="btn btn-dark" id="add_data" value="Tambah" readonly
                                            style="width:80px">
                                        <script type="text/javascript">
                                        $(function() {
                                            $('#add_data').click(function() {
                                                var logistic_name = $('#logistic_name').val();
                                                var qty = $('#qty').val();
                                                $('#list tbody:last-child').append(
                                                    '<tr>' +
                                                    '<td>' + logistic_name + '</td>' +
                                                    '<td>' + qty + '</td>' +
                                                    '</tr>'
                                                );
                                            });
                                        });
                                        </script>
                                    </div>
                                </div>
                                <div class="row mx-auto">
                                    <table class="table table-bordered" id="list">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nama Logistik</th>
                                                <th>Jumlah</th>
                                                <!-- <th>Aksi</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>

                                <label for="total" class="font-weight-bold">Total Harga<abbr
                                        title="Required">*</abbr></label>


                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-center" id="category_span">Rp</span>
                                    </div>
                                    <input type="number" min="1" name="total" id="total" class="form-control" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Catatan<abbr
                                        title="Required">*</abbr></label>
                                <textarea name="notes" id="notes" cols="20" rows="5"
                                    class="form-control summernote-basic"></textarea>
                            </div>
                            <!-- button -->
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <a class="btn btn-secondary" href="<?php echo base_url('logistic_request') ?>"
                                role="button">Back</a>
                        </fieldset>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
function addHtmlTableRow() {

    //get table by id
    //create a new rows and cells
    //get value from input text
    //get the value into row cells
    var table = document.getElementById("list"),
        newRow = table.insertRow(table.length),
        cell1 = newRow.insertCell(0),
        cell2 = newRow.insertCell(2),
        logistic_name = document.getElementById("logistic_name").value,
        qty = document.getElementById("qty").value;

    cell1.innerHTML = logistic_name;
    cell2.innerHTML = qty;

}
// /* Shivving (IE8 is not supported, but at least it won't look as awful)
// /* ========================================================================== */

// (function(document) {
//     var
//         head = document.head = document.getElementsByTagName('head')[0] || document.documentElement,
//         elements = 'article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output picture progress section summary time video x'.split(' '),
//         elementsLength = elements.length,
//         elementsIndex = 0,
//         element;

//     while (elementsIndex < elementsLength) {
//         element = document.createElement(elements[++elementsIndex]);
//     }

//     element.innerHTML = 'x<style>' +
//         'article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}' +
//         'audio[controls],canvas,video{display:inline-block}' +
//         '[hidden],audio{display:none}' +
//         'mark{background:#FF0;color:#000}' +
//         '</style>';

//     return head.insertBefore(element.lastChild, head.firstChild);
// })(document);

// /* Prototyping
// /* ========================================================================== */

// (function(window, ElementPrototype, ArrayPrototype, polyfill) {
//     function NodeList() {
//         [polyfill]
//     }
//     NodeList.prototype.length = ArrayPrototype.length;

//     ElementPrototype.matchesSelector = ElementPrototype.matchesSelector ||
//         ElementPrototype.mozMatchesSelector ||
//         ElementPrototype.msMatchesSelector ||
//         ElementPrototype.oMatchesSelector ||
//         ElementPrototype.webkitMatchesSelector ||
//         function matchesSelector(selector) {
//             return ArrayPrototype.indexOf.call(this.parentNode.querySelectorAll(selector), this) > -1;
//         };

//     ElementPrototype.ancestorQuerySelectorAll = ElementPrototype.ancestorQuerySelectorAll ||
//         ElementPrototype.mozAncestorQuerySelectorAll ||
//         ElementPrototype.msAncestorQuerySelectorAll ||
//         ElementPrototype.oAncestorQuerySelectorAll ||
//         ElementPrototype.webkitAncestorQuerySelectorAll ||
//         function ancestorQuerySelectorAll(selector) {
//             for (var cite = this, newNodeList = new NodeList; cite = cite.parentElement;) {
//                 if (cite.matchesSelector(selector)) ArrayPrototype.push.call(newNodeList, cite);
//             }

//             return newNodeList;
//         };

//     ElementPrototype.ancestorQuerySelector = ElementPrototype.ancestorQuerySelector ||
//         ElementPrototype.mozAncestorQuerySelector ||
//         ElementPrototype.msAncestorQuerySelector ||
//         ElementPrototype.oAncestorQuerySelector ||
//         ElementPrototype.webkitAncestorQuerySelector ||
//         function ancestorQuerySelector(selector) {
//             return this.ancestorQuerySelectorAll(selector)[0] || null;
//         };
// })(this, Element.prototype, Array.prototype);

// /* Helper Functions
// /* ========================================================================== */

// function generateTableRow() {
//     var emptyColumn = document.createElement('tr');

//     emptyColumn.innerHTML = '<td><a class="cut">-</a><span contenteditable></span></td>' +
//         '<td><span contenteditable></span></td>';

//     return emptyColumn;
// }

// function parseFloatHTML(element) {
//     return parseFloat(element.innerHTML.replace(/[^\d\.\-]+/g, '')) || 0;
// }

// function parsePrice(number) {
//     return number.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,');
// }

// /* Update Number
// /* ========================================================================== */

// function updateNumber(e) {
//     var
//         activeElement = document.activeElement,
//         value = parseFloat(activeElement.innerHTML),
//         wasPrice = activeElement.innerHTML == parsePrice(parseFloatHTML(activeElement));

//     if (!isNaN(value) && (e.keyCode == 38 || e.keyCode == 40 || e.wheelDeltaY)) {
//         e.preventDefault();

//         value += e.keyCode == 38 ? 1 : e.keyCode == 40 ? -1 : Math.round(e.wheelDelta * 0.025);
//         value = Math.max(value, 0);

//         activeElement.innerHTML = wasPrice ? parsePrice(value) : value;
//     }

//     updateInvoice();
// }

// /* Update Invoice
// /* ========================================================================== */

// function updateInvoice() {
//     var total = 0;
//     var cells, price, total, a, i;

//     // update inventory cells
//     // ======================

//     for (var a = document.querySelectorAll('table.inventory tbody tr'), i = 0; a[i]; ++i) {
//         // get inventory row cells
//         cells = a[i].querySelectorAll('span:last-child');

//         // set price as cell[2] * cell[3]
//         price = parseFloatHTML(cells[2]) * parseFloatHTML(cells[3]);

//         // add price to total
//         total += price;

//         // set row total
//         cells[4].innerHTML = price;
//     }

//     // update balance cells
//     // ====================

//     // get balance cells
//     cells = document.querySelectorAll('table.balance td:last-child span:last-child');

//     // set total
//     cells[0].innerHTML = total;

//     // set balance and meta balance
//     cells[2].innerHTML = document.querySelector('table.meta tr:last-child td:last-child span:last-child').innerHTML = parsePrice(total - parseFloatHTML(cells[1]));

//     // update prefix formatting
//     // ========================

//     var prefix = document.querySelector('#prefix').innerHTML;
//     for (a = document.querySelectorAll('[data-prefix]'), i = 0; a[i]; ++i) a[i].innerHTML = prefix;

//     // update price formatting
//     // =======================

//     for (a = document.querySelectorAll('span[data-prefix] + span'), i = 0; a[i]; ++i)
//         if (document.activeElement != a[i]) a[i].innerHTML = parsePrice(parseFloatHTML(a[i]));
// }

// /* On Content Load
// /* ========================================================================== */

// function onContentLoad() {
//     updateInvoice();

//     var
//         input = document.querySelector('input'),
//         image = document.querySelector('img');

//     function onClick(e) {
//         var element = e.target.querySelector('[contenteditable]'),
//             row;

//         element && e.target != document.documentElement && e.target != document.body && element.focus();

//         if (e.target.matchesSelector('.add')) {
//             document.querySelector('table.inventory tbody').appendChild(generateTableRow());
//         } else if (e.target.className == 'cut') {
//             row = e.target.ancestorQuerySelector('tr');

//             row.parentNode.removeChild(row);
//         }

//         updateInvoice();
//     }

//     function onEnterCancel(e) {
//         e.preventDefault();

//         image.classList.add('hover');
//     }

//     function onLeaveCancel(e) {
//         e.preventDefault();

//         image.classList.remove('hover');
//     }

//     function onFileInput(e) {
//         image.classList.remove('hover');

//         var
//             reader = new FileReader(),
//             files = e.dataTransfer ? e.dataTransfer.files : e.target.files,
//             i = 0;

//         reader.onload = onFileLoad;

//         while (files[i]) reader.readAsDataURL(files[i++]);
//     }

//     function onFileLoad(e) {
//         var data = e.target.result;

//         image.src = data;
//     }

//     if (window.addEventListener) {
//         document.addEventListener('click', onClick);

//         document.addEventListener('mousewheel', updateNumber);
//         document.addEventListener('keydown', updateNumber);

//         document.addEventListener('keydown', updateInvoice);
//         document.addEventListener('keyup', updateInvoice);

//         input.addEventListener('focus', onEnterCancel);
//         input.addEventListener('mouseover', onEnterCancel);
//         input.addEventListener('dragover', onEnterCancel);
//         input.addEventListener('dragenter', onEnterCancel);

//         input.addEventListener('blur', onLeaveCancel);
//         input.addEventListener('dragleave', onLeaveCancel);
//         input.addEventListener('mouseout', onLeaveCancel);

//         input.addEventListener('drop', onFileInput);
//         input.addEventListener('change', onFileInput);
//     }
// }

// window.addEventListener && document.addEventListener('DOMContentLoaded', onContentLoad);
</script>