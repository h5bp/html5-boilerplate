FROM gitpod/workspace-full-vnc
# add your tools here
RUN sudo apt update
RUN sudo apt-get -y install chromium-browser
RUN sudo apt-get -y install firefox
RUN sudo apt update
#Plus:Installing Visual Studio Code for the brave
RUN sudo apt install -y software-properties-common apt-transport-https wget
RUN wget -q https://packages.microsoft.com/keys/microsoft.asc -O- | sudo apt-key add -
RUN sudo add-apt-repository "deb [arch=amd64] https://packages.microsoft.com/repos/vscode stable main"
RUN sudo apt update && sudo apt -y install code
