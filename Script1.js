$(document).ready(function () {
    var ball = $("#tennis-ball");
    var container = $("body");
    var containerWidth = container.width();
    var containerHeight = container.height();
    var ballWidth = ball.width();
    var ballHeight = ball.height();
    var positionX = 0;
    var positionY = 0;
    var speedX = 3; // viteză pe axa X
    var speedY = 3; // viteză pe axa Y

    function moveBall() {
        positionX += speedX;
        positionY += speedY;

        // Verificăm coliziunile cu marginile containerului
        if (positionX + ballWidth > containerWidth || positionX < 0) {
            speedX = -speedX; // inversăm direcția pe axa X
        }
        if (positionY + ballHeight > containerHeight || positionY < 0) {
            speedY = -speedY; // inversăm direcția pe axa Y
        }

        // Setăm noile poziții ale mingii
        ball.css("left", positionX);
        ball.css("top", positionY);
    }

    // Apelăm funcția pentru a începe animația
    setInterval(moveBall, 10);
});