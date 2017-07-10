/**
 * Created by Xavier on 1/2/2017.
 */
import _ from "lodash"

const getSymbols = content => {

  let symbols = [],
      will_do = true

  do {
    const symbol_start_index = content.indexOf("{%")
    const symbol_end_index = content.indexOf("%}") + "%}".length

    if (symbol_start_index > -1) {

      const symbol = content.substring(symbol_start_index, symbol_end_index)
      content = content.replace(symbol, '')
      symbols.push(symbol)
    } else {
      will_do = false
    }

  } while (will_do)

  return symbols
}

export const parseTitles = content => {

  let symbols = getSymbols(content),
      titles  = _.map(symbols, symbol => symbol.replace("{%", "").replace("%}", "").trim())

  return titles;
}

export const filterContentWithSpan = content => {
  let symbols = getSymbols(content),
      titles  = parseTitles(content)

  for (var i = 0; i < titles.length; i++) {
    content = content.replace(symbols[i], '<span class="selection"><strong>' + titles[i] + '</strong></span>')
  }
  return {'content': content, 'symbols': symbols, 'titles': titles};
}

export const getUpdatedTitles = (selectionTitles, parsedTitles) => {

  const titles = _.chain(selectionTitles)
                  .filter(titleObject => titleObject.status)
                  .map(titleObject => titleObject.title)
                  .value()


  const newTitles = _.filter(parsedTitles, title => titles.indexOf(title) < 0)

  // Remove choices for removed titles
  const removedTitles = _.filter(titles, title => parsedTitles.indexOf(title) < 0)

  return {newTitles: newTitles, removedTitles: removedTitles}

}


