function deleteComment(eventId, commentId) {
    fetch("/api/events/" + eventId + "/comments/" + commentId, {
        method: "POST",
    }).then((response) => {
        if (response.ok) {
            const comment = document.getElementById(
                "event_comment_" + commentId
            );
            if (comment != null) comment.remove();
        }
    });
}

function getComments() {
    const eventId = window.location.pathname.split("/").slice(-1)[0];
    fetch("/api/events/" + eventId + "/comments?size=5")
        .then((response) => response.text())
        .then((html) => {
            document.getElementById("comment_area").innerHTML = html;
        });
}

function submitComment() {
    const element_body = document.getElementById("new_comment_body");
    const value = element_body.value;
    if (value === "") return;
    const eventId = window.location.pathname.split("/").slice(-1)[0];
    const data = {
        body: value,
    };
    fetch("/api/events/" + eventId + "/comments", {
        method: "POST",
        body: JSON.stringify(data),
    })
        .then((response) => response.text())
        .then((html) => {
            const div = document.createElement("div");
            div.innerHTML = html;
            document.getElementById("comment_area").prepend(div);
            element_body.value = "";
        });
}

function viewMoreComments() {
    const eventId = window.location.pathname.split("/").slice(-1)[0];
    const comment_count = document.getElementsByClassName(
        "event_comment_entry"
    ).length;
    fetch("/api/events/" + eventId + "/comments?start=" + comment_count)
        .then((response) => response.text())
        .then((html) => {
            const div = document.createElement("div");
            div.innerHTML = html;
            document.getElementById("comment_area").append(div);
        });
}
