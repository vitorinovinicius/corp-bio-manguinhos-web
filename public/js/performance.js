


var reloadTime;
var reloadCount = 1;


setInterval(function () {
    console.log('EXECUTA TRANSICAO: ' + reloadCount);

    if(reloadCount == 1) {

        for(var i=1;i<7;i++) {
            console.log("COUNT TODOS:" + i);
            $("#box" + i).show();
            $("#box" + i).addClass("col-md-4");
            $("#box" + i).removeClass("col-md-12");
        }

    }

    if(reloadCount == 2){

        $("#box2").show();
        $("#box2").removeClass("col-md-4");
        $("#box2").addClass("col-md-12");

        for(var i=1;i<7;i++) {
            if(i != 2) {
                console.log("COUNT:" + i)
                $("#box" + i).hide();
                $("#box" + i).addClass("col-md-4");
                $("#box" + i).removeClass("col-md-12");
            }
        }

    }

    if(reloadCount == 3){

        $("#box3").show();
        $("#box3").removeClass("col-md-4");
        $("#box3").addClass("col-md-12");

        for(var i=1;i<7;i++) {
            if(i != 3) {
                console.log("COUNT:" + i);

                $("#box" + i).hide();
                $("#box" + i).addClass("col-md-4");
                $("#box" + i).removeClass("col-md-12");
            }
        }

    }

    if(reloadCount == 4){

        $("#box4").show();
        $("#box4").removeClass("col-md-4");
        $("#box4").addClass("col-md-12");

        for(var i=1;i<7;i++) {
            if(i != 4) {
                console.log("COUNT:" + i);

                $("#box" + i).hide();
                $("#box" + i).addClass("col-md-4");
                $("#box" + i).removeClass("col-md-12");
            }
        }

    }


    if(reloadCount == 5){

        $("#box5").show();
        $("#box5").removeClass("col-md-4");
        $("#box4").addClass("col-md-12");

        for(var i=1;i<7;i++) {
            if(i != 5) {
                console.log("COUNT:" + i);
                $("#box" + i).hide();
                $("#box" + i).addClass("col-md-4");
                $("#box" + i).removeClass("col-md-12");
            }
        }
    }

    if(reloadCount == 6){

        $("#box6").show();
        $("#box6").removeClass("col-md-4");
        $("#box6").addClass("col-md-12");

        for(var i=1;i<7;i++) {
            if(i != 6) {
                console.log("COUNT:" + i);

                $("#box" + i).hide();
                $("#box" + i).addClass("col-md-4");
                $("#box" + i).removeClass("col-md-12");
            }
        }

    }




    reloadCount++;

    if(reloadCount == 7) {
        reloadCount = 1;
    }


}, 8000);