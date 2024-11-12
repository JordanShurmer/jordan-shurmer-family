#!/bin/bash

new_f="./content/dev/small-bets/$(date +%F).php"
cp ./content/dev/small-bets/template "$new_f"
nvim "$new_f"
