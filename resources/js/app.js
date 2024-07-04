import "./bootstrap";

document.addEventListener("DOMContentLoaded", function() {
    const gameElement = document.querySelector(".game_id"),
        fieldset = document.querySelector(".advancing_team"),
        stageSelector = document.querySelector(".stages"),
        pageName = document.querySelector("body").getAttribute("data-page");

    gameElement?.addEventListener("change", (event) => {
        let gameId = gameElement.value;
    
        axios
            .post("ajaxGetTeams", {
                id: gameId,
            })
            .then(function (response) {
    
                if (response.data.game.stage > 6) {
                    fieldset.innerHTML =
                        '<label class="flex flex-justify-center flex-align-i-center" for="advancing_team"><i class="fa-solid fa-medal"></i></label>' +
                        '<select class="input-field text" name="advancing_team">' +
                        '<option value="">-- Vybrať --</option>' +
                        '<option value="' +
                        response.data.game.home_team.id +
                        '">' +
                        response.data.game.home_team.name +
                        "</option>" +
                        '<option value="' +
                        response.data.game.away_team.id +
                        '">' +
                        response.data.game.away_team.name +
                        "</option>" +
                        "</select>";
                } else {
                    fieldset.innerHTML = "";
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    stageSelector?.addEventListener("click", (event) => {

        const refreshEl = document.querySelector(".refresh-data");
        let stage = event.target,
            stageAttr = stage.getAttribute("data-stage");

        if (pageName == 'user') {

            const user_id = document.querySelector(".user-title").getAttribute("data-user");

            axios
                .post(pageName + '/update', {
                    stage: stageAttr,
                    id: user_id,
                })
                .then(response => {
                    refreshEl.innerHTML = response.data.html;
                    stage.parentNode.querySelector('.selected').classList.remove('selected');
                    stage.classList.add('selected');
                })
                .catch(function (error) {
                    console.log(error);
                });

        } else {

            axios
                .post(pageName + '/update', {
                    stage: stageAttr,
                })
                .then(response => {
                    refreshEl.innerHTML = response.data.html;
                    stage.parentNode.querySelector('.selected').classList.remove('selected');
                    stage.classList.add('selected');
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    });
});
