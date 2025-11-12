'use client';

import { useState, useEffect } from 'react';

interface Video {
  id: string;
  title: string;
  thumbnail: string;
  url: string;
}

interface ChannelCardProps {
  name: string;
  url: string;
  channelId: string;
  description: string;
}

export default function ChannelCard({ name, url, channelId, description }: ChannelCardProps) {
  const [channelData, setChannelData] = useState<{
    thumbnail: string;
    subscriberCount: string;
    videoCount: string;
  } | null>(null);
  const [recentVideos, setRecentVideos] = useState<Video[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Simular dados do canal (em produção, usar YouTube Data API)
    const mockChannelData = {
      thumbnail: `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&size=200&background=random`,
      subscriberCount: '1.2K',
      videoCount: '45',
    };

    const mockVideos: Video[] = [
      {
        id: '1',
        title: 'Vídeo Recente 1',
        thumbnail: `https://picsum.photos/seed/${channelId}1/320/180`,
        url: `${url}/videos`,
      },
      {
        id: '2',
        title: 'Vídeo Recente 2',
        thumbnail: `https://picsum.photos/seed/${channelId}2/320/180`,
        url: `${url}/videos`,
      },
      {
        id: '3',
        title: 'Vídeo Recente 3',
        thumbnail: `https://picsum.photos/seed/${channelId}3/320/180`,
        url: `${url}/videos`,
      },
    ];

    setTimeout(() => {
      setChannelData(mockChannelData);
      setRecentVideos(mockVideos);
      setLoading(false);
    }, 500);
  }, [name, channelId, url]);

  if (loading) {
    return (
      <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden animate-pulse">
        <div className="h-48 bg-gray-300 dark:bg-gray-700"></div>
        <div className="p-6 space-y-4">
          <div className="h-6 bg-gray-300 dark:bg-gray-700 rounded w-3/4"></div>
          <div className="h-4 bg-gray-300 dark:bg-gray-700 rounded w-full"></div>
          <div className="h-4 bg-gray-300 dark:bg-gray-700 rounded w-5/6"></div>
        </div>
      </div>
    );
  }

  return (
    <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
      {/* Header do Canal */}
      <div className="relative h-32 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500">
        <div className="absolute -bottom-12 left-6">
          <img
            src={channelData?.thumbnail}
            alt={name}
            className="w-24 h-24 rounded-full border-4 border-white dark:border-gray-800 shadow-lg"
          />
        </div>
      </div>

      {/* Informações do Canal */}
      <div className="pt-16 px-6 pb-4">
        <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">{name}</h3>
        <p className="text-gray-600 dark:text-gray-400 text-sm mb-4">{description}</p>
        
        <div className="flex gap-4 mb-4 text-sm">
          <div className="flex items-center gap-1">
            <span className="text-gray-500 dark:text-gray-400">📊</span>
            <span className="text-gray-700 dark:text-gray-300">{channelData?.subscriberCount} inscritos</span>
          </div>
          <div className="flex items-center gap-1">
            <span className="text-gray-500 dark:text-gray-400">🎬</span>
            <span className="text-gray-700 dark:text-gray-300">{channelData?.videoCount} vídeos</span>
          </div>
        </div>

        <a
          href={url}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-block w-full text-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 mb-4"
        >
          Visitar Canal
        </a>
      </div>

      {/* Vídeos Recentes */}
      <div className="px-6 pb-6">
        <h4 className="text-lg font-semibold text-gray-900 dark:text-white mb-3">Vídeos Recentes</h4>
        <div className="space-y-3">
          {recentVideos.map((video) => (
            <a
              key={video.id}
              href={video.url}
              target="_blank"
              rel="noopener noreferrer"
              className="flex gap-3 group"
            >
              <img
                src={video.thumbnail}
                alt={video.title}
                className="w-32 h-18 object-cover rounded-lg group-hover:opacity-80 transition-opacity"
              />
              <div className="flex-1">
                <p className="text-sm text-gray-800 dark:text-gray-200 line-clamp-2 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                  {video.title}
                </p>
              </div>
            </a>
          ))}
        </div>
      </div>
    </div>
  );
}
