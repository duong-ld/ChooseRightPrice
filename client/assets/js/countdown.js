$('.timer').circularCountDown({
    size: 60,
    colorCircle: 'red',
    fontSize: 16,
    delayToFadeOut: 0,
    reverseLoading: true,
    duration: {
        seconds: (end_time - current_time)
    },
    end: function () {
        clearInterval(myInterval);
        alert('Time out');
        document.getElementById("question").elements['answer'][0].value = 0;
        document.getElementById("question").elements['answer'][0].checked = true;
        // document.forms["questionForm"].submit();
        document.getElementById("question").submit();
        countdown.destroy();
        // alert(document.getElementById("questionForm").elements['answer'][0].value);
    }
});