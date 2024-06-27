import "./bootstrap";

const gameElement = document.querySelector(".game_id"),
    fieldset = document.querySelector(".advancing_team");

gameElement.addEventListener("change", (event) => {
    let gameId = gameElement.value;

    axios
        .post("ajaxGetTeams", {
            id: gameId,
        })
        .then(function (response) {
            // console.log(response.data.game);

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
