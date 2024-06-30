@prepend('css')
    <style>
        section.table_panel {
            box-shadow: 0 0 10px 0 #00000022;
            border-radius: 8px;
            padding: 10px;
        }

        section.table_panel .panel::-webkit-scrollbar {
            display: none
        }

        section.table_panel .panel {
            overflow: auto;
        }

        .error {
            color: var(--error) !important;
        }

        .error:hover {
            background: rgba(var(--error_rgb), 0.2) !important;
        }

        .warn {
            color: var(--warn_dark) !important;
        }

        .warn:hover {
            background: rgba(var(--warn_rgb), 0.2) !important;
        }

        .info {
            color: var(--info) !important;
        }

        .info:hover {
            background: rgba(var(--info_rgb), 0.2) !important;
        }

        .success {
            color: var(--success) !important;
        }

        .success:hover {
            background: rgba(var(--success_rgb), 0.2) !important;
        }

        table {
            width: 100%;
            border: 1px solid rgba(var(--prime_rgb), 0.2);
            border-collapse: collapse;
        }

        table tbody tr:nth-child(even) {
            background: rgba(var(--prime_rgb), 0.05);
        }

        table :is(th, td) {
            padding: 10px;
            text-align: left;
            font-size: 0.9em;
            font-weight: 500;
            border: 1px solid rgba(var(--prime_rgb), 0.2);
        }

        table .serial {
            width: 60px;
            text-align: center;
        }

        table .actions {
            width: 0;
            white-space: nowrap;
        }

        i.menu_btn {
            position: relative;
        }

        i.menu_btn menu {
            text-align: initial;
            position: absolute;
            font-family: var(--font);
            font-weight: 500;
            list-style-type: none;
            background: white;
            top: 120%;
            padding: 5px;
            z-index: 1;
            border-radius: 10px;
            right: -7px;
            font-size: 0.9em;
            display: flex;
            flex-direction: column;
            gap: 3px;
            transition: all 0.2s;
            filter: drop-shadow(0 0 20px #00000022);
        }

        i.menu_btn menu:not(.active) {
            top: 150%;
            opacity: 0;
            visibility: hidden;
        }

        i.menu_btn menu::before {
            content: "";
            background: white;
            padding: 7px;
            top: -6px;
            right: 15px;
            position: absolute;
            rotate: 45deg;
            z-index: -1;
            border-radius: 3px;
        }

        i.menu_btn menu .menu_item {
            border-radius: 5px;
            cursor: pointer;
            color: var(--gray_700);
            padding: 02px 20px 02px 10px;
        }

        i.menu_btn menu.active:not(:hover) .menu_item:first-of-type,
        i.menu_btn menu .menu_item:hover {
            color: var(--prime);
            background: rgba(var(--prime_rgb), 0.2);
        }

        .actions {
            text-align: center;
        }
    </style>
@endprepend
<section class="table_panel">
    <div class="panel">
        <table class="mu-table">
            <thead>
                <tr>
                    <td colspan="100">
                        <div class="rflex jcsb aic">
                            <div class="results">
                                <p>
                                    Showing <b>10</b> to <b>20</b> of 57
                                    rows
                                </p>
                            </div>
                            <div class="rflex">
                                <form action="" method="post" class="rflex">
                                    <input type="text" name="" id="" />
                                    <button type="submit" class="mu-btn">
                                        <i class="fa-solid fa-search"></i>
                                    </button>
                                </form>
                                <div class="group_opt">
                                    <i class="icon fa-solid fa-eye"></i>
                                    <i class="icon fa-solid fa-trash"></i>
                                    <i class="icon fa-solid fa-trash"></i>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                {{ $thead ?? '' }}
            </thead>
            {{ $tbody ?? '' }}
            <tbody>
                <tr>
                    <th class="serial">1</th>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td class="actions">
                        <i class="icon fa-solid fa-list-ul menu_btn">
                            <menu>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-edit"></i>
                                    <span>Update</span>
                                </li>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-eye"></i>
                                    <span>Toggle Status</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Force Delete</span>
                                </li>
                            </menu>
                        </i>
                    </td>
                </tr>
                <tr>
                    <th class="serial">2</th>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td class="actions">
                        <i class="icon fa-solid fa-list-ul menu_btn">
                            <menu>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-edit"></i>
                                    <span>Update</span>
                                </li>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-eye"></i>
                                    <span>Toggle Status</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Force Delete</span>
                                </li>
                            </menu>
                        </i>
                    </td>
                </tr>
                <tr>
                    <th class="serial">3</th>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td class="actions">
                        <i class="icon fa-solid fa-list-ul menu_btn">
                            <menu>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-edit"></i>
                                    <span>Update</span>
                                </li>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-eye"></i>
                                    <span>Toggle Status</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Force Delete</span>
                                </li>
                            </menu>
                        </i>
                    </td>
                </tr>
                <tr>
                    <th class="serial">4</th>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td>Hiii</td>
                    <td class="actions">
                        <i class="icon fa-solid fa-list-ul menu_btn">
                            <menu>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-edit"></i>
                                    <span>Update</span>
                                </li>
                                <li class="menu_item">
                                    <i class="icon fa-solid fa-eye"></i>
                                    <span>Toggle Status</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </li>
                                <li class="menu_item error">
                                    <i class="icon fa-solid fa-trash"></i>
                                    <span>Force Delete</span>
                                </li>
                            </menu>
                        </i>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100">
                        <div class="rflex jcsb">
                            <select name="" id="">
                                <option value="">10 entries</option>
                                <option value="">25 entries</option>
                                <option value="">50 entries</option>
                            </select>
                            <div class="results rflex aic">
                                <p><b>10</b> - <b>20</b> of 57</p>
                                <div class="rflex">
                                    <i class="icon fa-solid fa-chevron-left"></i>
                                    <i class="icon fa-solid fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
@prepend('js')
    <script>
        $(".menu_btn").perform((n) => {
            n.addEvent("click", (e) => {
                let menu = n.$("menu")[0].MU;
                let hide = (e) => {
                    if (!n.node.contains(e.target)) {
                        menu.removeClass("active");
                        document.removeEventListener("click", hide);
                    }
                };
                if (menu.hasClass("active")) {
                    if (!menu.node.contains(e.target)) {
                        document.removeEventListener("click", hide);
                        menu.removeClass("active");
                    }
                } else {
                    menu.addClass("active");
                    document.addEventListener("click", hide);
                }
            });
        });
        $(".toggle_btn").perform((x) => {
            x.node.addEventListener("click", function(e) {
                e.stopPropagation();
                ajax({
                    url: this.MU.get("data-api"),
                    success: (res) => {
                        res = JSON.parse(res);
                        alert(res.msg);
                        if (res.success) {
                            let tr = $(this.closest("tr"));
                            if (res.status == "ACTIVE") {
                                tr.MU.removeClass("disabled");
                            } else {
                                tr.MU.addClass("disabled");
                            }
                        } else {}
                    },
                });
            });
        });
        $(".delete_btn").perform((x) => {
            x.node.addEventListener("click", function(e) {
                e.stopPropagation();
                if (confirm("Are you sure to delete")) {
                    if (
                        !x.get("data-force") ||
                        confirm(
                            "Force Delete will remove all realated data. Are you sure to do this."
                        )
                    ) {
                        ajax({
                            url: this.MU.get("data-api"),
                            success: (res) => {
                                res = JSON.parse(res);
                                alert(res.msg);
                                if (res.success) {
                                    let tr = $(this.closest("tr"));
                                    tr.remove();
                                } else {}
                            },
                        });
                    }
                }
            });
        });
    </script>
@endprepend
