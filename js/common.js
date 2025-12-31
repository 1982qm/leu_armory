function setText(id, txt, suffisso) {
    $("#" + id).text("");
    if (txt != undefined) $("#" + id).text(txt + (suffisso != undefined ? suffisso : ""));
}

function getValore(array, nome) {
    var el = array.filter(obj => { return obj.nome == nome });
    return (el[0] == undefined) ? "" : el[0].valore;
}

function getResistenza(array, nome) {
    var el = array.filter(obj => { return obj.nome == nome });
    return (el[0] == undefined) ? "0 (0%)" : (el[0].valore + "\t(" + el[0].perc + ")");
}

function getEq(json, side) {
    if (json.used) {
        side = isNull(side, "");
        var nome = json.name;
        nome = nome.replaceAll("<r>", "</span>");

        //<r,g,b:r,g,b>
        const regex = /<\d+,\d+,\d+:\d+,\d+,\d+>/g;

        nome.matchAll(regex).forEach(
            element => {
                var match = element[0];
                match = match.replaceAll("<", "");
                match = match.replaceAll(">", "");
                var colors = match.split(":");
                nome = nome.replaceAll(element[0], "<span style='color:rgb(" + colors[0] + ")'>");
            }
        );

        if (side == "" || side == "_2") {
            var out = `<span style="color:rgb(191,191,191)">[</span><span style="color:` + json.rarity.color + `">` + json.rarity.short + `</span><span style="color:rgb(191,191,191)">|</span><span style="color: #00FE1E; white-space: pre;">` + (json.level < 10 ? ` ` : ``) + (json.level < 100 ? ` ` + json.level : json.level) + `</span><span style="white-space: pre; color:rgb(191,191,191)"">] </span><span onmouseover="showEqInfo(this,'` + side + `')" onmouseout="hideEqInfo(this,'` + side + `')">` + nome + `</span>`;
        } else {
            var out = `<span onmouseover="showEqInfo(this,'` + side + `')" onmouseout="hideEqInfo(this,'` + side + `')">` + nome + `</span><span style="white-space: pre; color:rgb(191,191,191)"> [</span><span style="color: #00FE1E; white-space: pre;">` + (json.level < 10 ? ` ` : ``) + (json.level < 100 ? ` ` + json.level : json.level) + `</span><span style="color:rgb(191,191,191)">|</span><span style="color:` + json.rarity.color + `">` + json.rarity.short + `</span><span style="color:rgb(191,191,191)">]</span>`;
        }

        out = out + getEqPowers(json, side);

        return out;
    } else {
        return " ";
    }
}

function getEqPowers(json, side) {
    var out = "";

    if (json.powers != undefined && json.powers.length > 0) {
        out = "<div class='card eqPower" + side + "' style='width: 18rem;'>" +
            "  <div class='card-header'>Proprietà</div>" +
            "    <ul class='list-group list-group-flush'>";

        if (json.ac != undefined) out = out + "<li class='list-group-item eqPowerItem'><span>Ac:\t</span><span style='color: #00FE1E;'>" + json.ac + "</span></li>";
        if (json.dice != undefined) out = out + "<li class='list-group-item eqPowerItem'><span>Dadi:\t</span><span style='color: cyan;'>" + json.dice + "</span></li>";

        json.powers.forEach(
            element => {
                if (element.power == "Potere Speciale") {
                    out = out + "<li class='list-group-item eqPowerItem'><span>" + element.power + ":\t</span><span class='specialPowerName'>" + findSpecialPower(element.value) + "</span></li>";
                    out = out + "<li class='list-group-item eqPowerItem'><span class='specialPowerDesc'>" + findSpecialPowerDesc(element.value) + "</span></li>";
                } else if (element.power == "Incantesimo su Arma") {
                    out = out + "<li class='list-group-item eqPowerItem'><span>" + element.power + ":\t</span><span style='color: #00FE1E;'>" + findWeaponSpell(element.value) + "</span></li>";
                } else {
                    out = out + "<li class='list-group-item eqPowerItem'><span>" + element.power + ":\t</span><span style='color: #00FE1E;'>+" + element.value + (element.power.startsWith("Eff.") ? "%" : "") + "</span></li>";
                }
            }
        );

        out = out + "</ul></div>";
    }

    return out;
}

function showEqInfo(el, side) {
    var eqPower = $(el).parent().find('.eqPower' + side);
    if (eqPower != undefined) {
        $(eqPower).show();
    }
}

function hideEqInfo(el, side) {
    var eqPower = $(el).parent().find('.eqPower' + side);
    if (eqPower != undefined) {
        $(eqPower).hide();
    }
}

function findWeaponSpell(idx) {
    var out = idx.toString();
    json_spell_armi.lista.forEach(
        element => {
            if (element.spellID == idx) {
                out = element.spellName;
            }
        }
    )

    return out;
}

function findSpecialPower(idx) {
    var out = "";
    json_poteri_speciali.lista.forEach(
        element => {
            if (element.powerID == idx) {
                out = element.powerName;
            }
        }
    )

    return out;
}

function findSpecialPowerDesc(idx) {
    var out = "";
    json_poteri_speciali.lista.forEach(
        element => {
            if (element.powerID == idx) {
                out = element.powerDescription;
            }
        }
    )

    out = out.replaceAll("[mTit]", "</span>");
    out = out.replaceAll("[mVal]", "<span style='color: cyan;'>");
    out = out.replaceAll("[FIDMG]", "<span style='color: red;'>");

    return out;
}

function setPlayerImg(json, custom_path, imgid) {
    var forza_reload = "";
    //var forza_reload = "?t=" + new Date().getTime();

    if (custom_path != null) {
        $("#" + imgid).attr("src", custom_path + forza_reload);
    } else {
        if (json.player.classe != undefined) {
            if (json.player.main_class != undefined) {
                $("#" + imgid).attr("src", "img\\" + json.player.main_class.toLowerCase() + ".png" + forza_reload);
            } else {
                $("#" + imgid).attr("src", "img\\" + json.player.classe.toLowerCase() + ".png" + forza_reload);
            }
        }
    }
}

function isNull(txt, def) {
    if (txt == undefined || txt.toString().trim().length == 0) {
        return def;
    } else {
        return txt;
    }
}
