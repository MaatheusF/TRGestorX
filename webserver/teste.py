from bs4 import BeautifulSoup
import requests

url = 'https://en.wikipedia.org/wiki/Web_scraping'


html_page = requests.get(url)
#html_source = html_page.text
html_source = '<html><body><div><table><tr><td>aa</td><td>aa</td></tr></table></div></body></html>'

soup = BeautifulSoup(html_source, 'html.parser')

td_tags = soup.find_all('td')

for td in td_tags:
    print(td, '\n')