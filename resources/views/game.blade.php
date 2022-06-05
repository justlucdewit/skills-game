<div>
    score: <span id="score"></span> points
</div>

<div id="player"></div>

<br />

<button onclick="endGame()">End game</button>
<button onclick="leaderboards()">Leaderboard</button>

<script type="text/javascript">
    let score = -10;
    const player = document.getElementById("player");
    let sessionId = null;

    const uint8ArrayToBase64 = (x) => btoa(Array.from(x).map((c) => String.fromCharCode(c)).join(''));
    
    const startGame = async () => {
        // Create a new session via the API
        const res = await fetch('/api/game/create');
        const data = await res.json();
        sessionId = data.id;

        // Set the score to 10
        updateScore();
    }

    const updateScore = () => {
        if (sessionId !== null) {
            score += 10;
            document.getElementById("score").innerText = score;
            player.style.marginLeft = `${score}px`;
        }

        fetch(`/api/game/${sessionId}/update`, {
            method: 'POST',
            body: score,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    }

    const endGame = async () => {
        await fetch(`/api/game/${sessionId}/end`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        location.reload();
    }
    
    const leaderboards = () => {
        window.location = "/lb";
    }
    
    startGame();
    
    player.onclick = () => {
        updateScore();
    }
</script>

<style type="text/css">
#player {
    width:  50px;
    height: 50px;
    background: blue;
}
</style>