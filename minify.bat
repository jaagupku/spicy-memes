cd public_html\assets\css

:: merge all *style.css files into merged.css
copy /b *style.css merged.css
java -jar ..\..\..\yuicompressor-2.4.8.jar merged.css -o merged.min.css
del merged.css

cd ..\js

:: delete all minified .js files
del min\*.js

:: create .min.js files
java -jar ..\..\..\yuicompressor-2.4.8.jar *.js -o ".js$:.min.js"

:: move all .min.js files to min folder
move *.min.js min\

cd ..\..\..
