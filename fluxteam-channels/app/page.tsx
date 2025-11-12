import ChannelCard from '@/components/ChannelCard';
import channelsData from '@/data/channels.json';

export default function Home() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
      {/* Header */}
      <header className="bg-white dark:bg-gray-800 shadow-md">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center">
            <h1 className="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 mb-2">
              Canais FluxTeam
            </h1>
            <p className="text-gray-600 dark:text-gray-400 text-lg">
              Conheça nossos criadores de conteúdo e seus vídeos mais recentes
            </p>
          </div>
        </div>
      </header>

      {/* Grid de Canais */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {channelsData.map((channel) => (
            <ChannelCard
              key={channel.id}
              name={channel.name}
              url={channel.url}
              channelId={channel.channelId}
              description={channel.description}
            />
          ))}
        </div>

        {/* Seção de Adicionar Mais Canais */}
        <div className="mt-16 text-center">
          <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-2xl mx-auto">
            <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              Quer adicionar seu canal?
            </h2>
            <p className="text-gray-600 dark:text-gray-400 mb-6">
              Entre em contato com a equipe FluxTeam para fazer parte desta comunidade incrível!
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <button className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105">
                Entrar em Contato
              </button>
              <button className="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105">
                Saiba Mais
              </button>
            </div>
          </div>
        </div>
      </main>

      {/* Footer */}
      <footer className="bg-white dark:bg-gray-800 mt-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center text-gray-600 dark:text-gray-400">
            <p className="text-sm">
              © 2025 FluxTeam. Todos os direitos reservados.
            </p>
            <p className="text-xs mt-2">
              Feito com ❤️ para a comunidade FluxTeam
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
}
