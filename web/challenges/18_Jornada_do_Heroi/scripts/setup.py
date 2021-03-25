import sys 
import os

if len(sys.argv) < 3:
    print("Por favor, envie o path em que deseja montar o chall e o valor 0")
    print("Exemplo: 'python setup.py /var/www hashLocation 0'")
    exit(1)

arg_path         = sys.argv[1]
arg_hashLocation = sys.argv[2]
arg_depth        = sys.argv[3]

max_depth     = 4
max_folders   = 4

transversal =  '../' * int(arg_depth)
index_normal = 'base_index.html'
index_end    = 'base_end.html'
index_flag   = 'base_flag.html'


if int(arg_depth) < max_depth:
    # print("Criando pastas...")
    for i in range(0,max_folders):
        if not os.path.isdir("{}/{}".format(arg_path,i)):
            os.mkdir("{}/{}".format(arg_path,i))

    # print("Criando base_index.html")
    os.system('cp -u {} {}/index.html'.format(index_normal, arg_path))

    # print("Chamando para os filhos")
    for i in range(0,max_folders):
        os.system("python3 setup.py {}/{} {} {}".format(arg_path, i, arg_hashLocation ,int(arg_depth)+1))

if int(arg_depth) == max_depth:
    if "1/3/2/0" in arg_path:
        os.system('cp -u {} {}/index.html'.format(index_flag, arg_path))
    else:
        os.system('cp -u {} {}/index.html'.format(index_end, arg_path))
    
# print("Replace #PATH# com o path do desafio")
os.system('sed -i \'s/HASHLOCATION/{}/g\' {}/index.html'.format(arg_hashLocation, arg_path))

if int(arg_depth) == 1:
    print("path {} finalizado".format(arg_path))
exit(0)