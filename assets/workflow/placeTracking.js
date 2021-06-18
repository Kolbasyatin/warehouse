/**
 *
 *
 *
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

console.log('sdf');
let a = 1;
console.log(a);