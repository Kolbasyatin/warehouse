async function sha1(str) {
    const buffer = new TextEncoder('utf-8').encode(str);
    const digest = await crypto.subtle.digest('SHA-1', buffer);

    return Array.from(new Uint8Array(digest)).map( x => x.toString(16).padStart(2,'0') ).join('');
}

$(function () {
    let currentPlace = $('#current-place').data('current-place');
    let workflowName = $('#current-workflow-name').data('workflow-name');
    let $svg = $(`svg#${workflowName}`);

    sha1(currentPlace).then(placeHash => {
        let search = 'place_' + placeHash;
        $('g.node title:contains("'+search +'")', $svg).each(function(j, place) {
            let parentPlace = $(place).parent();
            let ref = $('ellipse', parentPlace);
            ref.attr('stroke', 'red');
            let newEllipse = ref.clone();
            newEllipse.attr('rx', ref.attr('rx') * .9);
            newEllipse.attr('ry', ref.attr('ry') * .9);
            ref.after(newEllipse);
        });
    })

});

/**
 async function sha1( str ) {
                    const buffer = new TextEncoder( 'utf-8' ).encode( str );
                    const digest = await crypto.subtle.digest('SHA-1', buffer);
                    // Convert digest to hex string
                    const result = Array.from(new Uint8Array(digest)).map( x => x.toString(16).padStart(2,'0') ).join('');
                    return result;
                }
 */
/**
 <script>
 $(function() {

        var name = "{{ task.marking }}".replace(/[^\w]/i, '_').toLowerCase();
        var $svg = $('#state_machine-task');

        sha1(name).then(function (placeHash) {
            console.log(name, placeHash);
            let search = 'place_' + placeHash;
            console.log('searching for ' + search + ' in $svg');

            $('g.node title:contains("'+search +'")', $svg).each(function(j, place) {
                console.log("now looking for " + name);
                console.log(place);
                    console.log('found ' + name, j, place);
                    var place = $(place).parent();
                    var ref = $('ellipse', place);
                    ref.attr('stroke', 'red');
                    var newEllipse = ref.clone();
                    newEllipse.attr('rx', ref.attr('rx') * .9);
                    newEllipse.attr('ry', ref.attr('ry') * .9);
                    ref.after(newEllipse);
            });
        });

        // let placeHash = sha1(name);
        // let placeHash = crypto.createHash('sha1').update(name).digest("hex");
    });
 </script>
 */
