$('.timer').circularCountDown({
    size: 60,
    colorCircle: 'red',
    fontSize: 16,
    reverseLoading: true,
    duration: {seconds: (start_time-current_time)},
    end: function(){
        alert('Time out');
        document.getElementById("questionForm").elements['answer'][0].value = 0;
        document.getElementById("questionForm").elements['answer'][0].checked = true;
        document.getElementById("questionForm").submit();
        // alert(document.getElementById("questionForm").elements['answer'][0].value);
    }
});
