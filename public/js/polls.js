function changePollVote(pollId, optionId) {
    const eventId = window.location.pathname.split("/").slice(-1)[0];
    const is_delete = !document.getElementById(
        "poll_" + pollId + "_option_" + optionId
    ).checked;
    fetch("/api/events/" + eventId + "/polls/" + pollId + "/" + optionId, {
        method: is_delete ? "DELETE" : "POST",
    }).then((response) => {
        if (!response.ok) {
            alert("wow");
            return;
        }
        const elem = document.getElementById(
            "option_" + optionId + "_voter_count"
        );
        const curr_count = parseInt(elem.innerHTML);
        elem.innerHTML = is_delete ? curr_count - 1 : curr_count + 1;
    });
}
