FROM gitpod/workspace-full-vnc
# add your tools here
RUN sudo apt update
RUN sudo apt-get -y install chromium-browser
RUN sudo apt-get -y install firefox
# Installing Opera
RUN wget -qO- https://deb.opera.com/archive.key | sudo apt-key add - && sudo add-apt-repository "deb [arch=i386,amd64] https://deb.opera.com/opera-stable/ stable non-free"
RUN sudo apt install -y opera-stable
#Installing Brave Browser
RUN curl -s https://brave-browser-apt-release.s3.brave.com/brave-core.asc | sudo apt-key --keyring /etc/apt/trusted.gpg.d/brave-browser-release.gpg add -
RUN sudo sh -c 'echo "deb [arch=amd64] https://brave-browser-apt-release.s3.brave.com `lsb_release -sc` main" >> /etc/apt/sources.list.d/brave.list'
RUN sudo apt update && sudo apt install -y brave-browser brave-keyring
RUN sudo apt update
#Plus:Installing Visual Studio Code for the brave
RUN sudo apt install -y software-properties-common apt-transport-https wget
RUN wget -q https://packages.microsoft.com/keys/microsoft.asc -O- | sudo apt-key add -
RUN sudo add-apt-repository "deb [arch=amd64] https://packages.microsoft.com/repos/vscode stable main"
RUN sudo apt update && sudo apt -y install code
