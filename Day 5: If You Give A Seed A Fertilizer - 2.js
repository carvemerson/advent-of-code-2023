const readline = require('readline');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
    terminal: false
});

let seeds = [];
let maps = {};
let key = '';
let minLocation = Number.MAX_SAFE_INTEGER;

rl.on('line', (input) => {
    if (!input) {
        return;
    }
    if (input.indexOf('seeds:') !== -1) {
        seeds = input.split(': ')[1].split(' ').map(Number);
    } else if (input.indexOf('map:') !== -1) {
        key = input;
        maps[key] = [];
    } else {
        maps[key].push(input.split(' ').map(Number));
    }
});

rl.on('close', () => {
    for (let i = 0; i < seeds.length / 2; i++) {
        let startSeeder = seeds[i * 2];
        let endSeeder = seeds[i * 2] + seeds[i * 2 + 1];
        for (let j = startSeeder; j < endSeeder; j++) {
            console.log(j);
            let mappedTo = j;
            for (let map of Object.values(maps)) {
                for (let row of map) {
                    if (mappedTo >= row[1] && mappedTo < row[1] + row[2]) {
                        let diff = mappedTo - row[1];
                        mappedTo = row[0] + diff;
                        break;
                    }
                }
            }
            minLocation = Math.min(minLocation, mappedTo);
        }
        console.log('opaa');
    }
    console.log(minLocation);
});
